<?php 
require_once("./stackAPI.class.php");
$stacks = new stackAPI();
$search = $_GET['search'] ?? "";
$page = $_GET['page'] ?? 1;
if(!empty($search))
$get_image = $stacks->get_stack('search', ['per_page' => 40, "query" => $search, "page" => $page]);
else
$get_image = $stacks->get_stack('curated', ['per_page' => 40, "page" => $page]);
$pages = ceil(( $get_image['result']['total_results'] ?? 1 ) / 40);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Image and Video Stack API</title>
    <!-- Google Font icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- Bootstrap Framework CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">

    <!-- jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Bootstrap Framework JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div id="jumbotron" class="w-100 sticky-top py-4 px-5">
        <h1 class="text-center" id="app-title"><strong>Simple Image Stack</strong></h1>
        <div id="app-description" class="py-2">Discover a Collection of Free Image Stacks. All media on this site is sourced through the <b>pexels.com</b> API. Uncover a world of captivating visuals at your fingertips!</div>
        <div id="seachbox-container" class="mt-5">
            <div class="mb-3">
                <input type="search" id="search" placeholder="Enter Keywords Here" class="form-control form-control-lg rounded-pill" aria-label="Search input" value="<?= $search ?>">
            </div>
        </div>
    </div>
    <div class="container-lg py-5">
        <div class="d-flex justify-content-center mb-3">
            <?php if($page != 1): ?>
                <a class="btn btn-sm btn-primary rounded-pill px-4" href="./?<?= ((!empty($search)) ? "search={$search}" : "") ?><?= (empty($search) ? "?page=" : "&page=") ?><?= intval($page) - 1 ?>">Previous</a>
            <?php endif; ?>
            <div class="text-muted mx-5"><?= "{$page}/{$pages}" ?></div>
            
            <?php if($pages > 1 && $page < $pages): ?>
                <a class="btn btn-sm btn-primary rounded-pill px-4" href="./?<?= ((!empty($search)) ? "search={$search}" : "") ?><?= (empty($search) ? "?page=" : "&page=") ?><?= intval($page) + 1 ?>">Next</a>
            <?php endif; ?>
        </div>
        <div class="d-flex flex-wrap w-100 justify-content-between mb-3">
            <?php if($get_image['status'] == 'success' && isset($get_image['result']) && !empty($get_image['result']) && isset($get_image['result']['photos']) && !empty($get_image['result']['photos'])): ?>
            <?php foreach($get_image['result']['photos'] as $key => $row): ?>
                <?php 
                $filename = pathinfo($row['src']['medium'], PATHINFO_FILENAME);    
                ?>
                <a href="javascript:void(0)" class="media-item" data-key='<?= $key ?>' data-filename="<?= $filename ?>">
                    <img src="<?= $row['src']['medium'] ?>" alt="<?= $row['alt'] ?>">
                    <div class="media-item-details-hover">
                        <div class="media-photographer text-truncate">By: <?= $row['photographer'] ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <?php if($page == 1): ?>
                <a class="btn btn-sm btn-primary rounded-pill px-4" href="./?<?= ((!empty($search)) ? "search={$search}" : "") ?><?= (empty($search) ? "?page=" : "&page=") ?><?= intval($page) - 1 ?>">Previous</a>
            <?php endif; ?>
            <div class="text-muted mx-5"><?= "{$page}/{$pages}" ?></div>
            
            <?php if($pages > 1 && $page < $pages): ?>
                <a class="btn btn-sm btn-primary rounded-pill px-4" href="./?<?= ((!empty($search)) ? "search={$search}" : "") ?><?= (empty($search) ? "?page=" : "&page=") ?><?= intval($page) + 1 ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="modal" id="media-preview" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable rounded-0 modal-xl">
            <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title">Media Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body rounded-0">
                <div class="container-fluid">
                    <div class="w-100 d-flex flex-row-reverse">
                        <div class="col-lg-8 col-md-7 col-sm-12">
                            <div id="preview-media"></div>
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-12">
                            <h6 class="text-muted"><strong>Photographer:</strong></h6>
                            <h5 class="ps-4 mb-3"><strong><span id="phtotographer"></span></strong></h5>
                            <h6 class="text-muted"><strong>Downloads:</strong></h6>
                            <div id="downloads" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer rounded-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <script>
        var __stacked = JSON.parse(`<?= json_encode(($get_image['result']['photos'] ?? [])) ?>`)
    </script>
    <script src="script.js"></script>
</body>
</html>
