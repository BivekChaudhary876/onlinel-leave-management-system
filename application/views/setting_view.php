<form method="GET" action="">
    <div class="form-group">
        <label for="page">Page</label>
        <input type="number" name="page" class="form-control" value="<?= $page ?>">
    </div>
    <div class="form-group">
        <label for="per_page">List per page</label>
        <input type="number" name="per_page" class="form-control" value="<?= $per_page ?>">
    </div>
    <input type="submit" class="btn btn-light" value="Show">
</form>
