<div class="card-body text-center">
    <div class="position-relative d-inline-block">
        <span class="contact-active position-absolute rounded-circle bg-success">
            <span class="visually-hidden"></span>
        </span>
    </div>
    <h5 class="mt-4 mb-1">{{ $categorydiscount->discount_name }}</h5>
</div>

<div class="card-body">
    <!-- Category Discount Info Table -->
    <div class="table-responsive table-card mb-4">
        <table class="table table-borderless mb-0">
            <tbody>
                <tr>
                    <td class="fw-medium" scope="row">Category Name:</td>
                    <td>: {{ $categorydiscount->category ? $categorydiscount->category->category_name : 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">Discount:</td>
                    <td>: {{ $categorydiscount->discount }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">From Date:</td>
                    <td>: {{ $categorydiscount->from_date }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">To Date:</td>
                    <td>: {{ $categorydiscount->to_date }}</td>
                </tr>
            </tbody>
        </table>
    </div>
{{--
    <div class="table-responsive table-card">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Product Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoryproducts as $product)
                    <tr>
                        <td>
                            {{ $product->product_id }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    --}}
</div>
