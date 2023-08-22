<?php
if (isset($success_msg)){
    foreach($success_msg as $success_msg){
        echo '<script>Swal.fire("Any fool can use a computer")</script>';
    }
}
if (isset($warning_msg)){
    foreach($warning_msg as $warning_msg){
        echo 'swal("'.$warning_msg.'","","success");';
    }
}
if (isset($info_msg)){
    foreach($info_msg as $info_msg){
        echo 'swal("'.$info_msg.'","","success");';
    }
}
if (isset($error_msg)){
    foreach($error_msg as $error_msg){
        echo 'swal("'.$error_msg.'","","success");';
    }
}
?>