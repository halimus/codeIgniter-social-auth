<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-top: 100px;">

            <?php 
                if ($this->facebook->is_authenticated()) {
                    $connected = true;
                    
                    //echo '<pre>';
                    //print_r($user);
                    //echo '</pre>';
                    
                    $user_id = $user['id'];
                    $user_name = $user['name'];
                    $user_email = $user['email'];
                    $user_picture = $user['picture']['data']['url'];
                    //$user_picture = '<img src="'.$user_picture.'" alt="">';
                    
                    /*foreach ($user as $key => $value) {
                        if ($key != 'picture') {
                            echo '<p>' . $key . ': ' . $value . '</p>';
                        } else {
                            $url_image = $value['data']['url'];
                            echo '<img src="' . $url_image . '" alt="">';
                        }
                    }
                    */
                }
            ?>
            <div id="is_logout" style="<?php if(@$connected) echo 'display:none';?>">
                <button type="button" class="btn btn-primary" id="login">Connect with facebook</button>
            </div>



            <div id="is_login" style="<?php if(@!$connected) echo 'display:none';?>">
                <div class="user">
                    <div class="user_id"><?php echo @$user_id;?></div>
                    <div class="user_name"><?php echo @$user_name;?></div>
                    <div class="user_email"><?php echo @$user_email;?></div>
                    <div class="user_picture"><img src="<?php echo @$user_picture;?>" alt=""></div>
                </div>
                <br>
                <button type="button" class="btn btn-danger" id="logout">Logout</button>
            </div>



        </div>
    </div>
</div>