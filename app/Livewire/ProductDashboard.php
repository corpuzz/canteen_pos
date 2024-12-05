<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $name = '';
    public $description = '';
    public $price = '';
    public $stock = '';
    public $category = '';
    public $image_url = '';
    public $isCreating = false;
    public $editingProductId = null;

    public function mount()
    {
        $this->isCreating = false;
    }

    public function render()
    {
        $products = Product::when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%')
                             ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                return $query->where('category', $this->category);
            })
            ->paginate(10);

        $categories = Product::distinct('category')->pluck('category');

        return view('livewire.product-dashboard', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
        ]);

        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category,
            'image_url' => $this->image_url,
        ]);

        $this->reset(['name', 'description', 'price', 'stock', 'category', 'image_url', 'isCreating']);
        session()->flash('message', 'Product created successfully.');
    }

    public function delete(Product $product)
    {
        $product->delete();
        session()->flash('message', 'Product deleted successfully.');
    }

    public function startEditing(Product $product)
    {
        $this->editingProductId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category = $product->category;
        $this->image_url = $product->image_url;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
        ]);

        $product = Product::find($this->editingProductId);
        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category,
            'image_url' => $this->image_url,
        ]);

        $this->reset(['name', 'description', 'price', 'stock', 'category', 'image_url', 'editingProductId']);
        session()->flash('message', 'Product updated successfully.');
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'description', 'price', 'stock', 'category', 'image_url', 'editingProductId', 'isCreating']);
    }

    public function toggleCreating()
    {
        $this->isCreating = !$this->isCreating;
    }

    protected $listeners = [
        'toggle-creating' => 'toggleCreating',
    ];
}
