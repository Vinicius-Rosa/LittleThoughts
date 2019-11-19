<?php 
    if(isset($this->dados["includes"]["scripts"])){
        foreach ($this->dados["includes"]["scripts"] as $script){
?>
            <script src="<?= $script ?>" <?php if($script == URL."assets/js/home.js"){echo 'id="homeJs"';} ?>></script>
<?php
        }
    }
?>
</body>
</html>
