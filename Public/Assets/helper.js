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
    const sortArrow = document.querySelector('.simple_table_template_sort_arrow');
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
    const search = document.getElementById('simple_table_template_search').value;
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
    const search = document.getElementById('simple_table_template_search').value;
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