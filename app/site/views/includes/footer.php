<?php 
    if(isset($this->dados["includes"]["scripts"])){
        foreach ($this->dados["includes"]["scripts"] as $script){
?>
            <script src="<?= $script ?>"></script>
<?php
        }
    }
?>
</body>
</html>
