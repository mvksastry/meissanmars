<?php

namespace App\Livewire\Common\Inventory;

use App\Models\Products;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class InventoryReview extends PowerGridComponent
{
    use WithExport;
    
    public string $tableName = 'products';
    public string $primaryKey = 'products.product_id';
    public string $sortField ='products.product_id';
    
    public function setUp(): array
    {
        //$this->showCheckBox('product_id');

        return [
            Exportable::make(fileName: 'my-inventory')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Products::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('product_id')
            ->add('pack_mark_code')
            ->add('category_id')
            ->add('resproject_id')
            ->add('catalog_id')
            ->add('name')
            ->add('pack_size')
            ->add('unit_id')
            ->add('num_packs')
            ->add('mfd_date_formatted', fn (Products $model) => Carbon::parse($model->mfd_date)->format('d/m/Y'))
            ->add('batch_code')
            ->add('vial_cost')
            ->add('item_currency')
            ->add('expiry_date_formatted', fn (Products $model) => Carbon::parse($model->expiry_date)->format('d/m/Y'))
            ->add('supplier_id')
            ->add('status_open_unopened')
            ->add('quantity_left')
            ->add('full_empty')
            ->add('storage_container_id')
            ->add('shelf_rack_id')
            ->add('box_id')
            ->add('box_position_id')
            ->add('open_storage')
            ->add('enteredby_id')
            ->add('date_entered_formatted', fn (Products $model) => Carbon::parse($model->date_entered)->format('d/m/Y'))
            ->add('notes')
            ->add('created_at_formatted', fn (Products $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            //Column::action('Action'),
            
            Column::make('Product id', 'product_id')
                ->sortable()
                ->searchable(),

            Column::make('Pack mark code', 'pack_mark_code')
                ->sortable()
                ->searchable(),

            Column::make('Category id', 'category_id')
                ->sortable()
                ->searchable(),

            Column::make('Resproject id', 'resproject_id')
                ->sortable()
                ->searchable(),

            Column::make('Catalog id', 'catalog_id')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Pack size', 'pack_size')
                ->sortable()
                ->searchable(),

            Column::make('Unit id', 'unit_id')
                ->sortable()
                ->searchable(),

            Column::make('Num packs', 'num_packs')
                ->sortable()
                ->searchable(),

            Column::make('Mfd date', 'mfd_date_formatted', 'mfd_date')
                ->sortable(),

            Column::make('Batch code', 'batch_code')
                ->sortable()
                ->searchable(),

            Column::make('Vial cost', 'vial_cost')
                ->sortable()
                ->searchable(),

            Column::make('Item currency', 'item_currency')
                ->sortable()
                ->searchable(),

            Column::make('Expiry date', 'expiry_date_formatted', 'expiry_date')
                ->sortable(),

            Column::make('Supplier id', 'supplier_id')
                ->sortable()
                ->searchable(),

            Column::make('Status open unopened', 'status_open_unopened')
                ->sortable()
                ->searchable(),

            Column::make('Quantity left', 'quantity_left')
                ->sortable()
                ->searchable(),

            Column::make('Full empty', 'full_empty')
                ->sortable()
                ->searchable(),

            Column::make('Storage container id', 'storage_container_id')
                ->sortable()
                ->searchable(),

            Column::make('Shelf rack id', 'shelf_rack_id')
                ->sortable()
                ->searchable(),

            Column::make('Box id', 'box_id')
                ->sortable()
                ->searchable(),

            Column::make('Box position id', 'box_position_id')
                ->sortable()
                ->searchable(),

            Column::make('Open storage', 'open_storage')
                ->sortable()
                ->searchable(),

            Column::make('Enteredby id', 'enteredby_id')
                ->sortable()
                ->searchable(),

            Column::make('Date entered', 'date_entered_formatted', 'date_entered')
                ->sortable(),

            Column::make('Notes', 'notes')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('mfd_date'),
            Filter::datepicker('expiry_date'),
            Filter::datepicker('date_entered'),
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }
  /*
    public function actions(Products $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->product_id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->product_id])
        ];
    }

  
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
