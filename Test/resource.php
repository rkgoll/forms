  <?php

   $file = $_FILES['file_upload'];
   $name = $file['name'];
   $type = $file['type'];
   $tmp_location = $file['tmp_name'];
   $upload = 'uploads';
   $final_destination = $upload.'/'.$name;
   $error = $file['error'];
   $max_upload_size = 2097152;
   $size = $file['size'];

   $allowedImageTypes = array(
    'image/png', 'image/jpeg', 'image/gif', 
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' , 
    'application/vnd.openxmlformats-officedocument.presentationml.presentation' 
);
   function imageTypeAllowed($imageType){
   global $allowedImageTypes;
   if(in_array($imageType, $allowedImageTypes))
    {
    return true;
    }

    else
    {
    return false;
    }
    }

   //Check for errors
   if($error > 0 || is_array($error)){
   die("Sorry an error occured");
   }

  //Check if file is image
  //Only required if image is only whjat we need
  //if(!getimagesize($tmp_location)){
  //die("Sorry, you can only upload image types");
  }

  if(!imageTypeAllowed($type)){
  die("Sorry, file type is not allowed");
  }

  if(file_exists($final_destination)){
  $final_destination = $upload.'/'.time().$name;
  }

  if(!move_uploaded_file($tmp_location, $final_destination)){
  die("Cannot finish upload, something went wrong");
  }

  ?>

  <h2>File Successfully uploaded!</h2>