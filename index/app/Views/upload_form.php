<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Form</title>
</head>
<body>

<?= form_open_multipart(base_url() . 'upload/upload_file') ?>
    <input type="file" name="userfile" size="20">
    <br>
    <input type="submit" value="Upload">
</form>

</body>
</html>


