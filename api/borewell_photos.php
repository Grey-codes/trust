<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $uploadDir = 'borewell/';
    $photoNames = [];

    // Create directory if not exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Fetch current photos from DB
    $stmt = $conn->prepare("SELECT photos FROM borewell WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($existingPhotos);
    $stmt->fetch();
    $stmt->close();

    $existingArray = array_filter(explode(',', $existingPhotos));

    // ==============================
    // 🔴 DELETE PHOTOS IF REQUESTED
    // ==============================
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_photos'])) {
        $toDelete = $_POST['delete_photos'];

        foreach ($toDelete as $photo) {
            $filePath = $uploadDir . basename($photo);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $existingArray = array_diff($existingArray, [$photo]);
        }

        // Update DB
        $updatedPhotos = implode(',', $existingArray);
        $update = $conn->prepare("UPDATE borewell SET photos = ? WHERE id = ?");
        $update->bind_param("si", $updatedPhotos, $id);
        $update->execute();
        $update->close();

        exit('Deleted');
    }

    // ==============================
    // 🟢 UPLOAD PHOTOS
    // ==============================
    if (isset($_FILES['photos'])) {
        foreach ($_FILES['photos']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['photos']['error'][$index] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['photos']['name'][$index], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    $newName = 'borewell_' . $id . '_' . time() . '_' . $index . '.png';
                    $fullPath = $uploadDir . $newName;

                    // Load and compress
                    $image = null;
                    if ($ext === 'jpg' || $ext === 'jpeg') {
                        $image = imagecreatefromjpeg($tmpName);
                    } elseif ($ext === 'png') {
                        $image = imagecreatefrompng($tmpName);
                    }

                    if ($image) {
                        imagepng($image, $fullPath, 8); // Compress
                        imagedestroy($image);
                        $photoNames[] = $newName;
                    }
                }
            }
        }

        if (!empty($photoNames)) {
            $mergedPhotos = array_merge($existingArray, $photoNames);
            $updatedPhotos = implode(',', $mergedPhotos);

            // Update DB
            $update = $conn->prepare("UPDATE borewell SET photos = ? WHERE id = ?");
            $update->bind_param("si", $updatedPhotos, $id);
            $update->execute();
            $update->close();
        }
if(isset($_SESSION['aId'])){
        header("Location: ../trustadmin/admin/viewBorewell.php");
        exit;
    }
    else{
            header("Location: ../trustsub/sub/viewBorewell.php");
        exit;
    }
}
} else {
    echo "Invalid Request.";
}
?>
