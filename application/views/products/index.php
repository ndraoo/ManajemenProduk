<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/style.css'); ?>">   
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class='bx bxs-store mr-2'></i>
            <span>Manajemen Product</span>
        </div>
        <div class="sidebar-menu">
            </div>
            <div class="sidebar-item">
                <a href="<?php echo site_url('products'); ?>" class="sidebar-link active">
                    <i class='bx bxs-package'></i>
                    <span>Products</span>
                </a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h1 class="h3 text-gray-800">Manajemen Product</h1>
            <div class="ms-auto">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                    <i class='bx bx-plus-circle'></i> Tambah Product
                </button>
            </div>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class='bx bxs-check-circle me-2'></i>
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class='bx bxs-error-circle me-2'></i>
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="bx bxs-error-circle me-2"></i>', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); ?>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class='bx bxs-package me-2'></i>Daftar Product</h5>
                <div class="d-flex align-items-center">
                    <div class="input-group me-2" style="width: 300px;">
                        <input type="text" class="form-control" placeholder="Cari products..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class='bx bx-search'></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="productsTable">
                        <thead>
                            <tr>
								<th data-sort="index" class="text-center">Nomor<span class="sort-icon"></span></th>
                                <th data-sort="name">Nama Product <span class="sort-icon"></span></th>
                                <th data-sort="price">Harga <span class="sort-icon"></span></th>
                                <th data-sort="stock">Jumlah Stock <span class="sort-icon"></span></th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach($products as $key => $item): ?>
                                    <tr data-index="<?php echo $key + 1; ?>" data-name="<?php echo strtolower($item->name); ?>" 
                                        data-price="<?php echo $item->price; ?>" 
                                        data-stock="<?php echo $item->stock; ?>">
										<td class="index-column text-center"><?php echo $key + 1; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0"><?php echo $item->name; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">Rp <?php echo number_format($item->price, 2); ?></div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($item->stock > 10): ?>
                                                    <div class="text-success me-2"><i class='bx bxs-check-circle'></i></div>
                                                <?php elseif($item->stock > 0): ?>
                                                    <div class="text-warning me-2"><i class='bx bxs-error-circle'></i></div>
                                                <?php else: ?>
                                                    <div class="text-danger me-2"><i class='bx bxs-x-circle'></i></div>
                                                <?php endif; ?>
                                                <span><?php echo $item->stock; ?> Stock</span>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($item->is_sell): ?>
                                                <span class="badge bg-success rounded-pill px-3">Dijual</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary rounded-pill px-3">Tidak Dijual</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1 edit-product" 
                                                    data-id="<?php echo $item->id; ?>"
                                                    data-name="<?php echo $item->name; ?>"
                                                    data-price="<?php echo $item->price; ?>"
                                                    data-stock="<?php echo $item->stock; ?>"
                                                    data-status="<?php echo $item->is_sell ? 'Dijual' : 'Tidak Dijual'; ?>">
                                                <i class='bx bxs-edit'></i>
                                            </button>
                                            <a href="<?php echo site_url('products/delete/'.$item->id); ?>" class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah kamu yakin ingin Menghapus Product?');">
                                                <i class='bx bxs-trash'></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr id="empty-row">
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class='bx bx-package' style="font-size: 3rem;"></i>
                                            <p class="mt-2">Product Tidak Tersedia.</p>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                                                Tambahkan Barang Pertama Anda
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="productForm" action="<?php echo site_url('products/add'); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="product_id" name="product_id" value="">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Product</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock" class="form-label">Jumlah Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Not Sold">Tidak Dijual</option>
                                <option value="Sold">Dijual</option>
                            </select>
                        </div>

                        <input type="hidden" id="addUrl" value="<?= site_url('products/add/'); ?>">
                        <input type="hidden" id="updateUrl" value="<?= site_url('products/update/'); ?>">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('public/assets/js/index.js'); ?>"></script>
</body>
</html>
