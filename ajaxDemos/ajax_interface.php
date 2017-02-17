<?php require('db_config.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>AJAX Demo</title>
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Cairo" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles0.css">
  </head>
  <body>
    <header>
    <h1>Read All Posts In A Category</h1>
  </header>
    <?php
    $query = "SELECT *
              FROM categories";
    $result = $db->query($query);
    //handy dandy way to check for query problems:
    if(! $result){
      echo $db->error;
    }
    //check to see if there are rows to show
    if($result->num_rows >= 1){
    ?>
    <select id="picker">
      <option>Choose a Category</option>
    <?php while($row = $result->fetch_assoc()){?>
        <option value="<?php echo $row['category_id']; ?>">
        <?php echo $row['name']; ?>
        </option>
    <?php }//end of while loop :)?>
    </select>
    <?php
  }//end of if statement num_row
    ?>
    <div id="displayArea">Pick A Category To View The Posts</div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
      $('#picker').change(function(){
        //get the ID value of the chosen category_id
        var category_id = this.value;
        //alert to indicate its working! :D
        // alert(category_id);
        //make a request to ajax-response.php
        $.ajax({
          method: 'GET',
          url: 'ajax_response.php',
          data: {'category_id' : category_id},
          dataType: 'html',
          success: function(response){
            $('#displayArea').html(response);
          }//end of response function
        });//end of ajax arguement
      });//end of onchange function :)
    $(document).on({
      ajaxStart: function(){$('#displayArea').addClass('loading');},
      ajaxStop: function(){$('#displayArea').removeClass('loading');}
    })



    </script>
  </body>
</html>
