<div class="appBottomMenu">
        <div class="item <?php if($active==1){echo 'active';} ?>">
            <a href="index.php">
                <p>
                    <i class="icon ion-ios-home"></i>
                    <span>Home</span>
                </p>
            </a>
        </div>
        <div class="item <?php if($active==2){echo 'active';} ?>">
            <a href="newapp.php">
                <p>
                <i>  <iconify-icon icon="material-symbols:forms-add-on-rounded" style="font-size: 30px;"></iconify-icon>
                </i>     <span>Create</span>
                
                    </p>
            </a>
        </div>
        <div class="item <?php if($active==4){echo 'active';} ?> ">
            <a href="view.php">
                <p>
                    <i class=""><iconify-icon icon="humbleicons:print" style="font-size: 30px;"></iconify-icon></i>
                    <span>View</span>
                </p>
            </a>
        </div>
     
        <div class="item <?php if($active==5){echo 'active';} ?> ">
            <a href="profile.php">
                <p>
                    <i class=""><iconify-icon icon="pajamas:profile" width="25"></iconify-icon></i>
                    <span>Profile</span>
                </p>
            </a>
        </div>
    </div>