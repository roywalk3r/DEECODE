<div>
    <h1>Categories</h1>

    @foreach ($categories as $category)
        <div>
            <h2>Category Name: {{ $category->name }}</h2>

            <h3>Children Categories:</h3>
            @if ($category->children->isEmpty())
                <p>No children categories</p>
            @else
                <ul>
                    @foreach ($category->children as $child)
                        <li>{{ $child->name }}</li>
                    @endforeach
                </ul>
            @endif

            <h3>Parent Category:</h3>
            @if ($category->parent)
                <p>{{ $category->parent->name }}</p>
            @else
                <p>No parent category</p>
            @endif

            <h3>Products:</h3>
            @if ($category->products->isEmpty())
                <p>No products</p>
            @else
                <ul>
                    @foreach ($category->products as $product)
                        <li>{{ $product->name }}</li>
                    @endforeach
                </ul>
            @endif

            <hr>
        </div>
    @endforeach
</div>
