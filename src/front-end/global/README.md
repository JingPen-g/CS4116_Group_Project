# Global Guide to Implmentation

### 1. General

The following should be at the top of every page
All content should be contained within the "main" div
                                                             
     <div class="invisible image-item"></div>
     <div id="main" class="container-fluid">       
    
         <!-- Used to generate paw print margin -->
         <div class="row">                         
                <div class="col left-container"></div>
                 <div class="col rigth-container"></div>
         </div>                
 
 
The following css file should be linked

     <link rel="stylesheet" href="../global/css/global-style.css">

The following script should be added at the bottom of each page to load the paw print margins

     <script src="../global/js/global-margin.js"></script>


### 2. Footer

The following script should be included at the top of every page

    include __DIR__ . '/../global/get-footer.php';

The following should be at the bottom of each page
 

    <!-- Footer --!>
    <?php generate_footer() ?>

