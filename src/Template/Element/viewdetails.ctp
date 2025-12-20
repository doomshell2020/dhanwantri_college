
<!doctype html>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>help-page</title>
  </head>
  <style>
    * {
    margin: 0px;
    padding: 0px;
    box-sizing: border-box;
   
}

img {
    max-width: 100%;
    height: auto;
}

.container {
    max-width: 1170px;
    width: auto;
    margin: auto;
    padding: 0px 15px;
}
#main {
    background: #fff;
    background-image: url(../textured_paper.png);
    background-size: cover;
}
#main h1 {
    font-size: 44px;
    text-align: center;
    font-weight: 700;
    margin: 20px 0px;
}
#main a .boxes {
    padding: 34px 10px;
    border: 1px solid #e1e1e1;
    margin-bottom: 16px;
    border-radius: 5px;
}
#main a .boxes .imgbox {
    width: 65px;
    height: 65px;
    background-color: #2d95e3;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
    margin-bottom: 12px;
    border-radius: 43px;
    transition: all .2s ease-in-out;
    box-shadow: 0 10px 20px rgb(189 189 189 / 19%), 0 6px 6px rgb(45 149 227 / 35%);
}
#main a .boxes .imgbox:hover {
    transform: translateY(-4px);
}
#main a .boxes img {
    width: 33px;
    display: block;
    margin: auto;
}
#main a .boxes h4 {
    font-size: 17px;
    margin: 0 !important;
    text-align: center;
    color: #000;
}
#main .ancor {
    text-decoration: none;
    display: contents;
}

  </style>

  <body>
 
    <div id="main">
        <div class="container">
            
            <div class="row">
            
             <h1>
                iDS Prime Help
            </h1>
                
            <?php     
            // $slugss = $this->Comman->helpmodule($slug);
          //  foreach($slugss as $val){ pr($val);die;
          ?>
                <div class="col-md-2">
                    <a class="ancor" href="<?php echo SITE_URL; ?>admin/help/category/<?php echo $val['slug'] ?>">
                    <div class="boxes">
                    <div class="imgbox animation-name: elementor-animation-wobble-top;">
                    <img src="<?php echo SITE_URL; ?>images/helpicon/<?php echo $val['image'] ?>" alt="img">
                    </div>
                    <h4>
                    <?php echo ucwords(strtolower($val['title']));  ?>
                    </h4>
                    </div>
                    </a>
                </div>
                


          <?php  } ?>
         
          </div>
        
        </div>
        
    </div>

   
  
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
  
</html>