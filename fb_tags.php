<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="images/viralfav.png" type="image/gif" sizes="16x16">
        <title>Viral</title>

        <link href="css/style.default.css" rel="stylesheet">

        <style type="text/css">
       
        
        .ck li{
            display: inline-block;
            text-decoration: none;
           

            border-radius: 5px 5px;
        }
        
        .panel-signin{
            background: #E0DFDF;
        }
        .panel-signin .panel-body, .panel-signup .panel-body{
            padding: 14px;
        }
       
         .check{
            display: block;
            width: 23px;
            margin: 5px auto;
            height: 23px;
            background-image: url(images/checkbox.png);
            border-radius: 4px;
            border: 1px solid #4C9C4E;
            background-position: -105px -62px;
            visibility:hidden;
        }
        .ck li .p{
             border: 1px solid #ddd;
             padding: 5px;
             width:48px;
             height:48px;
            border-radius: 5px 5px;
            background-image: url(images/social-icons.png);
            cursor: pointer;
        }
        
        .signin{background-color:#fff !important;}
          .cup{
            border-radius: 5px 5px;
            background-color: #3B589E;
            width: 77%;
            margin: 0 auto;
        }
        
        .cup .incup{
            display: inline-block;
            text-decoration: none;
            padding: 3px;
        }
        .steptext{
            color:#2BC2D4;
        }
        .cup-link{
            color:#E8E3E3
        }
        .panel-signin{
            background: #E0DFDF;
        }
       
        .panel-signin .panel-body, .panel-signup .panel-body{
            padding: 14px;
        }
        .cup{cursor:pointer;}
        .cup:hover a{color:#fff !important;}
        .signin{background-color:#fff !important;}
        .error{
        
        font-size:15px; color:red; font-style: italic;
        }
        </style>
    </head>
<?php //print_r($view); ?>
    <body class="signin">      
    <!-- for fb signup-->  
    <section id="sec1">
                </div></div>
            <div class="panel panel-signin">
                <div class="panel-body text-center cupan">
                    <div class="steptext"><strong>Step 1 Of 2</strong></div>
                    <h4>Connect With Facebook To Get InstantAces:</h4>
                    
                     
                            
                          <ul class=" cup"><li class="incup" style="border-left: 1px solid #fff;"><img  src="images/f.png" style="width:50px; margin-left:-96px;"></li><li class="incup"><a class="cup-link"  onClick="logInWithFacebook()">Sign Up With Facebook</a></li></ul>
                          


                       <span class="error" id="fb_error"></span>  
                    </div>
                </div><!-- panel-body -->
               
            </div><!-- panel -->
            
        </section>
    <!-- for share -->
        <section id="sec2" style="display: none;">
            
            <div class="panel panel-signin">
                <div class="panel-body text-center cupan">
                    <div class="steptext"><strong>Step 2 Of 2</strong></div>
                    <input type="hidden" id="tags" value="<?php if(isset($view['unlock_no_of_tags'])) echo $view['unlock_no_of_tags']; ?>">
                    <h4>Tag <?php echo $view['unlock_no_of_tags']; ?> facebook friends and get the coupon code :</h4>
                        
                      <ul class="ck" style="margin-left: -38px;">
                            <li>
                                <a class="btnShare" onclick='postToFeed(); return false;' ><p class="p p1" style="background-position: -562px -67px;" ></p></a>
                                <p class="check check1"></p>
                            </li>
                        </ul>
                    
                      
                     <span class="error" id="error_tags"></span>
                    </div>
                </div><!-- panel-body -->
               
            </div><!-- panel -->
            
            
            
        </section>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

<script type="text/javascript">
  logInWithFacebook = function() {

    FB.login(function(response) {
      if (response.authResponse) {
        //alert('You are logged in &amp; cookie set!');
        // Now you can redirect the user or do an AJAX request to
        // a PHP script that grabs the signed request from the cookie.
        var accessToken = response.authResponse.accessToken;
        document.getElementById('sec2').style.display='block';
         document.getElementById('sec1').style.display='none';
        //alert(accessToken);

           FB.api('/v2.2/me?fields=id,name,email', function(response) {
                      var collect_fb_id = response.id;

                      var name = response.name;
                      var email = response.email;
                      AjaxResponse(collect_fb_id,name,email);
           });
        
      } else {
      
         document.getElementById('fb_error'). innerHTML ="";
         document.getElementById('fb_error'). innerHTML ="You cancelled login. Please try again!!";
      }
    });
    return false;

  };

  window.fbAsyncInit = function() {

    FB.init({
      appId: '1073109212776631',
      cookie: true, // This is important, it's not enabled by default
      version: 'v2.2'
    });
  };

  (function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

   function postToFeed() {
 
        // calling the API ...
        var obj = {
          method: 'feed',
          redirect_uri: 'http://localhost:8888/viralso_app/index.php',
          link: '<?php echo $view['unlock_post_link']; ?>', //  URL must be valid to show popup ..otherwise popup will not load
          picture: 'http://app.viral-source.com/<?php echo $view['unlock_post_image_path']; ?>',
          name: '<?php echo $view['unlock_post_title']; ?>',
          caption: '<?php echo $view['unlock_post_link']; ?>',
          description: '<?php echo $view['unlock_post_desc']; ?>'
        };
 
        function callback(response) {
         // document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];

              FB.api(
                      response['post_id'],
                      function (response) {
                        if (response && !response.error) {
                          /* handle the result */
                          //console.log(response);
                          var story = response.story;
                          console.log(response.story);
                          var res = story.split("with");

                         // console.log(res);

                        
                         
                         if( res[1] ){
                         
         var tags_count;
         var tags_string = res[1];
          var tags = tags_string.split(" and ");
         
          if(tags.length == 2){
          
            console.log(tags[1]);
            var tags_1 = tags[1];
            var tags_and = tags_1.split(" ");
            
                tags_count = parseInt(tags_and[0]);
            
            if( tags_count >= 2 ){
            
            tags_count = tags_count +1;
        
            
            }else{
            
            tags_count = 2;
            console.log(tags_count);
            
            }
            
            
          }else{
          
            tags_count = 1;
            console.log(tags_count);
          }
          
                         // document.location.href = 'index.php?c=api&m=coupon';
                             var get_total_tags = document.getElementById('tags').value;
                             if( get_total_tags <= tags_count){
                             
                                document.location.href = 'index.php?c=api&m=coupon';
                             
                             }else{
                             
                                document.getElementById('error_tags'). innerHTML ="";
                                document.getElementById('error_tags'). innerHTML ="You haven't tagged <?php echo $view['unlock_no_of_tags']; ?> friends. Please try again!!";
                             
                             }

                         }else{
                            document.getElementById('error_tags'). innerHTML ="";
                            document.getElementById('error_tags'). innerHTML ="You haven't tagged anyone. Please try again!!";
                         }

                        }else{

                           console.log(response.error);

                        }
                      }
                  );
        }
 
        FB.ui(obj, callback);
      }
      

      // SEND COLLECTED DATA TO AJAX TO INSERT INTO DATABASE AND TO RESPONDER.....
      function AjaxResponse(collect_fb_id,name,email)
      {
        var collect_fb_id=collect_fb_id;
        var name=name;
        var email=email;
        //alert(collect_fb_id);
        

           $.ajax({
                    //dataType: 'json',?id=" + id + "&name=" + userName + "&email=" + emailId
                    type: 'POST',
                    url: 'index.php?c=ajax&m=load_ajax&collect_fb_id='+collect_fb_id + '&name=' + name + '&email=' +email, 
                    data:"",
                    success:function(response)
                                        {  
                                           return true;
                                           //alert(response);
                                        }
                        });
                    
        }
      
</script>