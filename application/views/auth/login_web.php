<?php if (!$this->facebook->is_authenticated()) : ?>

    <div class="login">
        <a href="<?php echo $this->facebook->login_url(); ?>">Login</a>
    </div>
    <?php 
       echo $this->facebook->login_url();
    ?>

<?php else : ?>

    <div class="user-info">

        <p><strong>User information</strong></p>
        <ul>
            <?php 
               foreach ($user as $key => $value){
                  if($key!='picture') {
                      echo '<li>'.$key.': '.$value.'</li>';
                  }
                  else{
                    $url_image = $value['data']['url'];
                    echo '<img src="'.$url_image.'" alt="">';
                  }
               }  
            ?>       
        </ul>
        
        <p>
            <a href="<?php echo $this->facebook->logout_url(); ?>">Logout</a>
        </p>
        <?php 
           //echo 'link='.$this->facebook->logout_url();
        ?>
    </div>

<?php endif; ?>


