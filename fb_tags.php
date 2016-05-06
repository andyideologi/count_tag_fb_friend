<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon"  type="image/gif" sizes="16x16">
        <title>Facebook Signup and Tag FB Friends</title>

       

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        
        <![endif]-->
     
    </head>

    <body class="signin">      
    <!-- for fb signup-->  
    <section id="sec1">
                </div></div>
            <div class="panel panel-signin">
                <div class="panel-body text-center cupan">
                    <div class="steptext"><strong>Step 1 Of 2</strong></div>
                    <h4>Connect With Facebook To Get InstantAces:</h4>
                    
                     
                            
                          <ul class=" cup"><li class="incup"><a class="cup-link"  onClick="logInWithFacebook()">Sign Up With Facebook</a></li></ul>
                          


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

  <script type="text/javascript">


  logInWithFacebook = function() {   // This login function get the access token and stores in coockie

    FB.login(function(response) {
      if (response.authResponse) {
        //alert('You are logged in &amp; cookie set!');
        // Now you can redirect the user or do an AJAX request to
        // a PHP script that grabs the signed request from the cookie.
        var accessToken = response.authResponse.accessToken;
        document.getElementById('sec2').style.display='block';
        document.getElementById('sec1').style.display='none';
        //alert(accessToken);

            FB.api('/v2.2/me?fields=id,name,email', function(response) {  // get name and email
                      var collect_fb_id = response.id;

                      var name = response.name;
                      var email = response.email;
                      
            });
        
      } else {
      
         document.getElementById('fb_error'). innerHTML ="";
         document.getElementById('fb_error'). innerHTML ="You cancelled login. Please try again!!";
      }

    });
    return false;

  };

  window.fbAsyncInit = function() {  // initialise the fb connection

    FB.init({
      appId: '1357040784322468',  // enter facebook app ID
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

   function postToFeed() {   // funtion that shares the post
 
        // calling the API ... content of post being shared...can be static or dynamic
        var obj = {
          method: 'feed',
          redirect_uri: 'http://app.viral-source.com/',
          link: '<?php echo $view['unlock_post_link']; ?>', //  URL must be valid to show popup ..otherwise popup will not load
          picture: 'http://app.viral-source.com/<?php echo $view['unlock_post_image_path']; ?>',
          name: '<?php echo $view['unlock_post_title']; ?>',
          caption: '<?php echo $view['unlock_post_link']; ?>',
          description: '<?php echo $view['unlock_post_desc']; ?>'
        };
 
        function callback(response) {
        

              FB.api(
                      response['post_id'],    // you will get the post id of post which you have shared
                      function (response) {

                        if (response && !response.error) {
                          /* handle the result */
                          //console.log(response);
                          var story = response.story;   // capture story which shows with whom you have shared the post
                          console.log(response.story);
                          var res = story.split("with");

                         // console.log(res);

                        
                         
                         if( res[1] ){   // check whether friend is tagged or not
                         
                               var tags_count;
                               var tags_string = res[1];
                               var tags = tags_string.split(" and ");  // check more than 2 friends are tagged or not
                               
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
                                                   
                                                      document.location.href = 'index.php?c=api&m=coupon'; // if count matches..go ahead
                                                   
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
 
        FB.ui(obj, callback);  // call to share the post and get response
      }
      
    
      
</script>