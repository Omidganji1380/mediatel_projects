<?php

namespace App\Http\Livewire\Front\Ad\Create\Main;

use App\Models\Ad\Category as AdCategory;

trait Category
{
    public int $backToCategory = 0;
    public string $selectedCategory = '';
    public string $categoryType = '';
    public $propertyType;
    public array $categories = [];

    /**
     * Add the category to the selected category property
     * determine the categoy type
     * determine the rent or sale for real estate categories
     *
     * @param integer $id
     * @return void
     */
    public function selectCategory($id)
    {
        $this->selectedCategory = $id;
        $category = AdCategory::find($id);

        if ($this->categoryType === 'real_estate') {
            if ($category?->sale_type === 'rent') {
                $this->categorySaleType = 'rent';
            } else {
                $this->categorySaleType = 'sale';
            }
            $this->propertyType = $category?->property_type;
            $this->goTo('realEstateForm');
        } else {
            $this->goTo('form');
        }
    }

    /**
     * check if the parent is the first parent or not
     *
     * @param integer $category_id
     * @return boolean
     */
    public function isFirstParent($category_id): bool
    {
        return in_array($category_id, $this->getFirstParent());
    }

    /**
     * Get the children of the category by category id
     *
     * @param int $category_id
     * @return Category
     */
    public function getChildrenThisCategory($category_id)
    {
        $category_id = $category_id === 0 ? null : $category_id;

        return \App\Models\Ad\Category::whereParentId($category_id)
            ->whereIsVisible(true)
            ->withCount('children')
            ->orderBy('position')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Retrieve the First parents of the category
     *
     * @return void
     */
    public function getFirstParent()
    {
        return $this->getChildrenThisCategory(null);
    }

    /**
     * Retreive the children of the category
     *
     * @param int $category_id
     * @return void
     */
    public function getChildren($category_id)
    {
        $category = AdCategory::find($category_id);
        $this->categoryType = $category->type;
        $this->checkPermission();
        $this->backToCategory = $category_id;
        $this->categories = [...$this->getChildrenThisCategory($category_id)];
    }

    /**
     * Retreive the children of the category on the back action
     *
     * @return void
     */
    public function getChildrenBack()
    {
        if ($this->isFirstParent($this->backToCategory)) {
            $this->backToCategory = 0;
            $this->categories = [...$this->getFirstParent()];
        } else {
            $parentId = \App\Models\Ad\Category::find($this->backToCategory)->parent_id;
            $this->backToCategory = $parentId === null ? 0 : $parentId;
            $this->categories = [...$this->getChildrenThisCategory($this->backToCategory)];
        }
    }
}
