<div class="container" id="main">
    <h2> Welcome, <?php print(session()->get('username')); ?></h2>
    <form action="<?php echo base_url()?>postquestion"> <button type="submit"> Post Question </button> </form> 

    <table class="table">
        <tr>
            <th>Username</th>
            <th>Subject</th>
            <th>Question</th>
            <th>Favourites</th>
            <th>Link</th>
        </tr>
    <?php
        
        foreach ($ques as $row) {
        print("<tr>");                        
        printf("    <td> %s </td>", $row['username']);
        printf("    <td> %s </td>", $row['subject']);
        printf("    <td> %s </td>", $row['question']);
        printf("    <td> %s </td>", $row['rating']);
        printf("    <td> <a href=\"".base_url()."question/%s\"> link </a> </td>", $row['id']);
        print("</tr>");
        }
              
    ?>
    </table>
</div>
