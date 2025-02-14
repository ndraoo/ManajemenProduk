<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Products</h1>

        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <div class="row mb-3">
            <div class="col-md-6">
                <h2><?php echo isset($product) ? 'Edit Product' : 'Add New Product'; ?></h2>
                <form action="<?php echo isset($product) ? site_url('products/update/'.$product->id) : site_url('products/add'); ?>" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Product</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($product) ? $product->name : set_value('name'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo isset($product) ? $product->price : set_value('price'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Jumlah stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="<?php echo isset($product) ? $product->stock : set_value('stock'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Not Sold" <?php echo (isset($product) && !$product->is_sell) ? 'selected' : ''; ?>>Not Sold</option>
                            <option value="Sold" <?php echo (isset($product) && $product->is_sell) ? 'selected' : ''; ?>>Sold</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo isset($product) ? 'Update Product' : 'Add Product'; ?></button>
                    <?php if(isset($product)): ?>
                        <a href="<?php echo site_url('products'); ?>" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <h2>Products List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Product</th>
                    <th>Harga</th>
                    <th>Jumlah Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach($products as $item): ?>
                        <tr>
                            <td><?php echo $item->name; ?></td>
                            <td>$<?php echo number_format($item->price, 2); ?></td>
                            <td><?php echo $item->stock; ?></td>
                            <td><?php echo $item->is_sell ? 'Sold' : 'Not Sold'; ?></td>
                            <td>
                                <a href="<?php echo site_url('products/edit/'.$item->id); ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="<?php echo site_url('products/delete/'.$item->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Tidak ada product.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
