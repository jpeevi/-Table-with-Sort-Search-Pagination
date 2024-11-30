<?php

//Pagination logic
$itemsPerPage = $queryParams['per_page'] ?? $perPageItems[0];


if (isset($queryParams['page']) && is_numeric($queryParams['page'])) {
    $currentPage = (int)$queryParams['page'];
} else {
    $currentPage = 1;
}

$totalItems = count($data);
$totalPages = ceil($totalItems / $itemsPerPage);
$lastPage = ceil($totalItems / $itemsPerPage);

if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

$offset = ($currentPage - 1) * $itemsPerPage;

$currentPageData = array_slice($data, $offset, $itemsPerPage);
//End of pagination logic

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4"><?php echo $title ?></h2>

    <!--Filters-->
    <div class="row mb-3">
        <?php

        for ($fc = 1;
        $fc <= count($filterbales);
        $fc++){

        $_currentFilterable = $filterbales[$fc - 1];

        if (($fc % 4) !== 0)
        {
            ?>
            <div class="col-md-3">
                <select onchange="manageFilterChange(event,'<?php echo $_currentFilterable['key']; ?>')"
                        id="woo_rzp_recon_filter_"<?php echo $_currentFilterable['key']; ?> class="form-select">
                    <option value=""><?php echo $_currentFilterable['display_name']; ?></option>
                    <?php
                    foreach ($_currentFilterable['values'] as $k => $v) {

                        if (isset($queryParams[$_currentFilterable['key']]) && $queryParams[$_currentFilterable['key']] == $k) {

                            echo '<option selected value="' . $k . '">' . $v . '</option>';

                        } else {

                            echo '<option value="' . $k . '">' . $v . '</option>';
                        }

                    }
                    ?>
                </select>
            </div>

            <?php
        } else
        {
        ?>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <select onchange="manageFilterChange(event,'<?php echo $_currentFilterable['key']; ?>')"
                    id="woo_rzp_recon_filter_"<?php echo $_currentFilterable['key']; ?> class="form-select">
                <option value=""><?php echo $_currentFilterable['display_name']; ?></option>
                <?php
                foreach ($_currentFilterable['values'] as $k => $v) {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                }
                ?>
            </select>
        </div>

        <?php
        }
        }
        ?>
    </div>

    <!--Search-->
    <div class="row mb-3">
        <div class="col-md-5 d-flex align-items-center">
            <input value="<?php echo(isset($queryParams['search']) ? $queryParams['search'] : '') ?>" type="text"
                   id="woo_rzp_recon_search" class="form-control me-2" placeholder="Search">
            <button onclick="manageSearch(event)" id="woo_rzp_recon_search_btn" class="btn btn-primary me-2">Search
            </button>
            <button onclick="clearSearch(event)" id="woo_rzp_recon_clear_btn" class="btn btn-secondary">Clear</button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <?php

                foreach ($columns as $k => $v) {

                    if (in_array($k, $sortables, true)) {
                        ?>

                        <th>
                            <a onclick="manageSortDirection(event,'<?php echo $k; ?>')"
                               href="?sort=<?php echo $k; ?>&order=<?php echo $queryParams['order'] ?? 'asc'; ?>"
                               id="woo_rzp_recon_sort_<?php echo $k; ?>" class="text-decoration-none">
                                <?php echo $v; ?>
                                <span class="woo_rzp_recon_sort_arrow">
                                        <?php echo (isset($queryParams['order']) && $queryParams['order'] === 'asc') ? '&#9650' : '&#9660'; ?>
                                    </span>
                            </a>
                        </th>

                        <?php
                    } else {

                        ?>

                        <th><?php echo $v; ?></th>

                        <?php
                    }
                }


                ?>
            </tr>
            </thead>
            <tbody id="woo_rzp_recon_table_body">
            <?php
            foreach ($currentPageData as $i => $d) {

                ?>

                <tr>

                    <?php

                    foreach ($d as $k => $v) {

                        ?>

                        <td><?php echo $v; ?></td>

                        <?php
                    }

                    ?>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <!--Pagination-->
    <div class="d-flex justify-content-between align-items-center">
        <div id="woo_rzp_recon_pagination_meta">
            <span>Total: <?php echo $totalItems; ?> items, Showing <?php echo $itemsPerPage; ?> items per page</span>
        </div>
        <nav>
            <ul class="pagination">

                <li class="page-item">
                    <a onclick="managePagination(event,1)" class="page-link" href="?page=1"
                       aria-label="First">&laquo;</a>
                </li>

                <?php if ($currentPage > 1) { ?>
                    <li class="page-item">
                        <a onclick="managePagination(event,<?php echo($currentPage - 1); ?>)" class="page-link"
                           href="?page=<?php echo($currentPage - 1); ?>" aria-label="Previous">&lsaquo;</a>
                    </li>
                <?php } ?>

                <li class="page-item active">
                    <a onclick="managePagination(event,<?php echo $currentPage; ?>)" class="page-link"
                       href="?page=<?php echo $currentPage; ?>"><?php echo $currentPage; ?></a>
                </li>

                <?php if ($currentPage < $lastPage) { ?>
                    <li class="page-item">
                        <a onclick="managePagination(event,<?php echo($currentPage + 1); ?>)" class="page-link"
                           href="?page=<?php echo($currentPage + 1); ?>"
                           aria-label="Next">&rsaquo;</a>
                    </li>
                <?php } ?>

                <li class="page-item">
                    <a onclick="managePagination(event,<?php echo $lastPage; ?>)" class="page-link"
                       href="?page=<?php echo $lastPage; ?>" aria-label="Last">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="mt-3">
        <select onchange="manageFilterChange(event,'per_page')" id="woo_rzp_recon_per_page" class="form-select w-auto">
            <?php
            foreach ($perPageItems as $i => $pageItem) {

                if (isset($queryParams['per_page']) && $queryParams['per_page'] == $pageItem) {

                    echo '<option selected value="' . $pageItem . '">' . $pageItem . ' per page</option>';

                } else {

                    echo '<option value="' . $pageItem . '">' . $pageItem . ' per page</option>';
                }
            }
            ?>
        </select>
    </div>
</div>

<script>

    function manageFilterChange(event, key) {

        const element = event.currentTarget;
        const selectedValue = element.value;

        if (isEmpty(selectedValue)) {
            removeQueryParamAndRefresh(key)
            return;
        }

        const queryParams = {};
        queryParams[key] = selectedValue;
        updateAndRefreshCurrentPage(queryParams)
    }

    function manageSortDirection(event, key) {

        event.preventDefault();
        const element = event.currentTarget;
        const sortParams = new URLSearchParams(element.href);
        const sortArrow = document.querySelector('.woo_rzp_recon_sort_arrow');
        const currentSortOrder = sortParams.get('order');
        let newSortOrder = "";

        if (currentSortOrder === 'asc') {
            newSortOrder = "desc";
            sortArrow.innerHTML = '&#9650;'

        } else {

            newSortOrder = "asc";
            sortArrow.innerHTML = '&#9660;'
        }

        const queryParams = {
            sort: key,
            order: newSortOrder
        };

        element.href = new URLSearchParams(queryParams).toString();

        updateAndRefreshCurrentPage(queryParams)
    }

    function managePagination(event, page) {

        event.preventDefault();

        const queryParams = {
            page: page
        };

        updateAndRefreshCurrentPage(queryParams)
    }

    function manageSearch(event) {
        event.preventDefault();
        const search = document.getElementById('woo_rzp_recon_search').value;
        if (!isEmpty(search)) {
            updateAndRefreshCurrentPage({
                search: search
            })
        } else {
            removeQueryParamAndRefresh('search')
        }
    }

    function clearSearch(event) {
        event.preventDefault();
        const search = document.getElementById('woo_rzp_recon_search').value;
        search.value = "";
        removeQueryParamAndRefresh('search')
    }

    function updateAndRefreshCurrentPage(queryParams) {
        const urlParams = new URLSearchParams(window.location.search);

        for (const key in queryParams) {
            if (queryParams.hasOwnProperty(key)) {
                const value = queryParams[key];
                urlParams.set(key, value);
            }
        }

        window.location.search = urlParams.toString();
    }

    function removeQueryParamAndRefresh(key) {
        const url = new URL(window.location.href);
        url.searchParams.delete(key);
        window.location.href = url.toString();
    }

    function isEmpty(value) {
        return (
            value === null ||
            value === undefined ||
            value === '' ||
            (Array.isArray(value) && value.length === 0) ||
            (typeof value === 'object' && !Array.isArray(value) && Object.keys(value).length === 0)
        );
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>