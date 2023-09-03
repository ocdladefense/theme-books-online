<?php

$books = array(
    "duii" => "DUII Notebook",
    "fsm" => "Felony Sentencing Manual"
);
?>
 
        <div class="toolbar">
    
            <div class="toolbar-section toolbar-left">
                <img class="logo" src="https://appdev.ocdla.org/content/images/logo.png" />
            </div>
            <div class="toolbar-section toolbar-right">

                <form id="chapter-search" autocomplete="off" tab-index="-1">
                    <div class="form-item">
                        <label for="query" style="display:none;">Search term</label>
                        <webc-autocomplete id="query" style="display:inline-block; width:275px;" />
                    </div>
                </form>

                <div id="user-area">

                    <a class="login" href="/logout">logout</a>
                    
                    <a id="user-icon" href="https://ocdla--ocdpartial.sandbox.my.site.com/AccountManager" title="Hello ">
                        <svg id="user-widget" width="40" height="40" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <circle cx="50" cy="50" r="50" style="fill: rgb(81 100 144);"></circle>
                                <text x="50%" y="50%" font-size="3.0em" fill="#ffffff" text-anchor="middle" stroke="#ffffff" stroke-width="0px" dy=".3em">SA</text>
                            </g>
                        </svg>
                    </a>

                </div><!-- end user-area -->

            </div>

            <div class="toolbar-bottom">
                <span class="nav-heading-item">Books Online</span> <i class="fa-solid fa-chevron-right"></i> <span class="nav-heading-item"><?php print $books[$book]; ?></span>
                <button>Feedback</button>
            </div>
        </div>

        <div class="toc">
            <?php
                $file = $contentPath . "/books/{$book}/toc.html";
                @include $file;
            ?>
        </div>
        
        <div class="workspace">


            <div class="document">
                        
                <!-- Template://breadcrumb -->
                <div class="breadcrumb">
                    <ul>
                        <li>Books Online</li>
                        <li><?php print $books[$book]; ?></li>
                    </ul>
                </div>

                <div class="chapter">

                    <!-- Template://title -->
                    <?= $out ?>
                </div>

                

            </div>


            <div class="outline">
                <div class="outline-content">

                </div>
            </div>
            
        </div>

        <div id="modal-backdrop">
            <div id="modal">
                <div id="modal-container" style="overflow-y:visible;"> 
                    <div id="modal-body" style="vertical-align:top;">
                        <div id="modal-title-bar">
                            <button style="float:right;" id="close-modal" type="button">X</button>
                            <div id="modal-title-bar-title"></div>
                        </div>
                        <div id="modal-left-nav" class="modal-toc" style="display:inline-block;width:25%; vertical-align:top;overflow-y:auto;overflow-y: auto;position: sticky;max-height: 600px;padding-right:25px;">

                        </div>
                        <div id="modal-content" style="display:inline-block; width:67%; vertical-align:top; overflow-y: auto; overflow-y: auto; max-height: 600px; padding: 35px;">

                        </div>
                    </div>
                </div>
                <div id="loading">
                    <div id="loading-wheel"></div>
                </div>
            </div>  
        </div>
 

        <?php require "footer.tpl.php"; ?>

 


