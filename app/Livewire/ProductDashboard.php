<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProductDashboard extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $name = '';
    public $description = '';
    public $price = '';
    public $stock = '';
    public $category = '';
    public $image_url = '';
    public $image;
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

    // public function create()
    // {
    //     $validatedData = $this->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'price' => 'required|numeric|min:0',
    //         'stock' => 'required|integer|min:0',
    //         'category' => 'required|string',
    //         'image' => 'nullable|image|max:3000', // max 1MB
    //     ]);

    //     if ($this->image) {
    //         $imagePath = $this->image->store('products', 'public');
    //         $validatedData['image_url'] = Storage::url($imagePath);
    //     }

    //     Product::create($validatedData);
    //     $this->reset(['name', 'description', 'price', 'stock', 'category', 'image_url', 'image', 'isCreating']);
    //     session()->flash('message', 'Product created successfully.');
    // }
    public function create()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'nullable', // Remove image-specific validation
        ]);

        if ($this->image) {
            // Check if it's a file upload or a URL
            if (is_string($this->image)) {
                // If it's a URL, download the image
                try {
                    $imageContents = file_get_contents($this->image);
                    if ($imageContents === false) {
                        throw new \Exception('Failed to download image');
                    }

                    // Generate a unique filename
                    $filename = 'products/' . uniqid() . '_' . basename($this->image);
                    
                    // Store the image
                    Storage::disk('public')->put($filename, $imageContents);
                    
                    $validatedData['image_url'] = Storage::url($filename);
                } catch (\Exception $e) {
                    \Log::error('Image download failed', [
                        'url' => $this->image,
                        'error' => $e->getMessage()
                    ]);
                    session()->flash('error', 'Failed to download image: ' . $e->getMessage());
                    return;
                }
            } else {
                // Existing file upload logic
                $imagePath = $this->image->store('products', 'public');
                $validatedData['image_url'] = Storage::url($imagePath);
            }
        }

        Product::create($validatedData);
        $this->reset(['name', 'description', 'price', 'stock', 'category', 'image_url', 'image', 'isCreating']);
        session()->flash('message', 'Product created successfully.');
    }
    public function updatedImage($value)
    {
        // Validate if the input is a URL
        if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
            // Additional check to ensure it's an image URL
            $headers = @get_headers($value, 1);
            
            if ($headers && isset($headers['Content-Type'])) {
                $contentType = is_array($headers['Content-Type']) 
                    ? $headers['Content-Type'][0] 
                    : $headers['Content-Type'];
                
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                
                if (!in_array(strtolower($contentType), $allowedTypes)) {
                    $this->reset('image');
                    session()->flash('error', 'Invalid image URL. Please use a valid image file.');
                    return;
                }
            }
        }
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
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|max:3000', // max 1MB
        ]);

        $product = Product::find($this->editingProductId);

        if ($this->image) {
            // Delete old image if exists
            if ($product->image_url) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            $imagePath = $this->image->store('products', 'public');
            $validatedData['image_url'] = Storage::url($imagePath);
        }

        $product->update($validatedData);
        $this->reset(['name', 'description', 'price', 'stock', 'category', 'image_url', 'image', 'editingProductId']);
        session()->flash('message', 'Product updated successfully.');
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'description', 'price', 'stock', 'category', 'image_url', 'image', 'editingProductId', 'isCreating']);
    }

    public function toggleCreating()
    {
        $this->isCreating = !$this->isCreating;
    }

    public function removeImage()
    {
        $this->image = null;
        $this->image_url = null;
    }

    protected $listeners = [
        'toggle-creating' => 'toggleCreating',
    ];
}
