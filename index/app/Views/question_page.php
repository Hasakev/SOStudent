<div class="container" id="main">
    <h2> <?= $question ?> </h2>
    <p> Posted by: <?= $username ?> <br>
    Time: <?= $time ?> <br>
    Subject: <?= $subject ?> </p>
    <?php $model = model('App\Models\Question_model'); 
    $username = session()->get('username');
    $id = session()->get('id');
    $id_user = $model->get_username($id);
    if ($username == $id_user) { ?>
    
    <!-- <button id="edit" onclick="">Edit</button> -->
    <?php } ?> 
    
    Favourites: <div id="currentRating"> <?= $rating ?> </div>
    <?php if ($model->has_liked($id, $username)) {?>
    <button id="fav" onclick="Favourite();">Unfavourite</button>
    <?php } else { ?>
    <button id="fav" onclick="Favourite();">Favourite</button> <br>
    <?php } ?>
    <button id="delete" onclick="DeleteQuestion();">Delete Question</button>

    <hr>
    <p> <?= $content ?> </p>
    <hr>
    <h4> Comments </h4>
    <form action="<?php echo base_url()?>addcomment"> <button type="submit"> Add Comment </button> </form> 
        <?php foreach ($comments as $comment): ?>

        <p><?php echo $comment['username'] ?>
        commented:
        <?php echo $comment['comment']; ?></p>
        <?php endforeach; ?>
</div>

<script>
		function DeleteQuestion() {
            if (confirm("Are you sure you want to delete the post? You will be redirected to homepage.")) {
            // Make an HTTP request to the controller endpoint
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/index/delete_question/"+<?=$id?>, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Request completed successfully
                    console.log("Controller executed successfully.");
                    window.location.href = "/index/login";
                }
            };
            xhr.setRequestHeader("X-Requested-With", "XMLHTTPRequest");
            xhr.send();
            }
        }
        function Favourite() {
            var xhr = new XMLHttpRequest();
            if (document.getElementById("fav").innerHTML == "Favourite") {
                document.getElementById("fav").innerHTML = "Unfavourite";
                rating = document.getElementById("currentRating").innerHTML;
                document.getElementById("currentRating").innerHTML = parseInt(rating) + 1;
                xhr.open("GET", "/index/like/"+<?=$id?>, true);
                xhr.setRequestHeader("X-Requested-With", "XMLHTTPRequest");
                xhr.send();
            } else {
                document.getElementById("fav").innerHTML = "Favourite";
                rating = document.getElementById("currentRating").innerHTML;
                document.getElementById("currentRating").innerHTML = parseInt(rating) - 1;
                xhr.open("GET", "/index/unlike/"+<?=$id?>, true);
                xhr.setRequestHeader("X-Requested-With", "XMLHTTPRequest");
                xhr.send();
            }
        }
    
</script>
