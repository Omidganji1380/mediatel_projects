@extends('front.base')
@section('head')
    {{-- <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script> --}}
@endsection
@section('seo')
@endsection

@php
    $isEn = \App::isLocale('en');
    $dir = $isEn ? 'right' : 'left';

@endphp

@section('styles')
    <style>
        .newads-list:hover::after {
            content: '';
            width: 18px;
            height: 18px;
            background-image: url({{ asset("images/icons8-$dir-arrow-64.png") }});
            background-repeat: no-repeat;
            background-size: cover;
            position: absolute;
            @if ($isEn)
                right: 20px !important;
                left: 95% !important;
            @else
                right: 95%;
                left : 20px !important;
            @endif
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
        }
    </style>
@endsection

@section('content')
    {{-- <div id="app"> --}}
    @livewire('front.ad.create.main')
    {{-- </div> --}}
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            @if ($message = Session::get('success'))
                Livewire.emit('swal:modal', {
                    'icon': 'success',
                    'title': 'پرداخت با موفقیت انجام شد.',
                    'timerProgressBar': true,
                    'timer': 20000,
                    'confirmButtonText': '<i class="fa fa-thumbs-up"></i> متوجه شدم',
                    'width': 300,
                })
                <?php
                Session::forget('success'); ?>
            @elseif ($message = Session::get('error'))
                Livewire.emit('swal:modal', {
                    'icon': 'error',
                    'title': 'پرداخت ناموفق.',
                    'timerProgressBar': true,
                    'timer': 20000,
                    'confirmButtonText': '<i class="fa fa-thumbs-up"></i> متوجه شدم',
                    'width': 300,
                })
                <?php
                Session::forget('error'); ?>
            @endif
        });
    </script>
@endsection
























{{-- @section('script') --}}{{-- <script> --}}{{--  --}}{{--   var categories = Vue.component("categories", { --}}{{--  --}}{{--     props: ["todo_list_prop"], --}}{{--  --}}{{--     data() { --}}{{--  --}}{{--       return{ --}}{{--  --}}{{--         ca: @json(\App\Models\Ad\Category::all()) --}}{{--  --}}{{--       } --}}{{--  --}}{{--     }, --}}{{--  --}}{{--     methods: { --}}{{--  --}}{{--       ee(e) { --}}{{--  --}}{{--         console.log(e,$('#list-group-id')) --}}{{--  --}}{{--         this.message = 'sss'; --}}{{--  --}}{{--         e.target.parentElement.dispatchEvent(new CustomEvent('input', {detail: 'ssssssssaaa'})) --}}{{--  --}}{{--         $('#list-group-id').dispatchEvent(new CustomEvent('input', {detail: 'ssssssssaaa'})) --}}{{--  --}}{{--       }, --}}{{--  --}}{{--       dd(e) { --}}{{--  --}}{{--         console.log('The time is: ' + e); --}}{{--  --}}{{--       }, --}}{{--  --}}{{--     }, --}}{{--  --}}{{--     template: `<div> --}}{{--  --}}{{-- <!--    <ul class="list-group" id="list-group-id">--> --}}{{--  --}}{{--     <li class="list-group-item" v-for="c in ca" :key="c.id" @click="ee" :value="c.id" >@{{ c.name }}</li> --}}{{--  --}}{{-- <!--    </ul>--> --}}{{--  --}}{{--   </div>`, --}}{{--  --}}{{--   }); --}}{{--  --}}{{--   --}}{{--  new Vue({ --}}{{--    el: "#app", --}}{{--    data: { --}}{{--      categories: @json(\App\Models\Ad\Category::withCount('children')->get()), --}}{{--      selectedCategory: null, --}}{{--      parentCategory: null, // backToParentCategory: null, --}}{{--      back: false, --}}{{--      isFirst: true, --}}{{--      clone: [], --}}{{--    }, --}}{{--    methods: { --}}{{--      selectParentCategory(e, c) { --}}{{--        this.parentCategory = c --}}{{--      }, --}}{{--      selectCategory(e, c) { --}}{{--        e.target.dispatchEvent(new CustomEvent('input', {detail: c.id})) --}}{{--      }, --}}{{--      backToParent() { --}}{{--        this.back = true; --}}{{--        // const parentCategory = this.categories.filter((category) => { --}}{{--        //   return category.id=this.parentCategory.parent_id --}}{{--        // }); --}}{{--        // console.log(this.parentCategory.parent_id) --}}{{--        // !== null,this.parentCategory,_.find(this.categories, function (o) { return o.id = this.parentCategory.parent_id; })) --}}{{--        setTimeout(() => { --}}{{--          console.log(this?.parentCategory?.parent_id) --}}{{--          if (this?.parentCategory?.parent_id && this.parentCategory.parent_id !== null) { --}}{{--            console.log(this?.parentCategory?.parent_id, 'lllllllllllll', this?.parentCategory?.parent_id, 'kkkkkkk') --}}{{--            this.parentCategory = _.find(this.categories, function (o) { --}}{{--              return o.id === this?.parentCategory?.parent_id; --}}{{--            }); --}}{{--          } --}}{{--          else { --}}{{--            this.parentCategory = null; --}}{{--          } --}}{{--        }, 1000); --}}{{--      }, --}}{{--    }, // components: { --}}{{--    //   categories, --}}{{--    // }, --}}{{--    computed: { --}}{{--      computedCategory() { --}}{{--        let orderBy --}}{{--        if (this.back || this.isFirst) { --}}{{--          console.log(this.back || this.isFirst) --}}{{--          const filter = this.categories.filter((category) => { --}}{{--            if (this.back) { --}}{{--              if (this?.parentCategory?.parent_id && this?.parentCategory?.parent_id !== null) { --}}{{--                return category.parent_id === this?.parentCategory?.parent_id; --}}{{--              } --}}{{--              else { --}}{{--                return category.parent_id === null; --}}{{--              } --}}{{--            } --}}{{--            if (this?.parentCategory?.id) { --}}{{--              return category.parent_id === this?.parentCategory?.id; --}}{{--            } --}}{{--            return category.parent_id === null; --}}{{--          }); --}}{{--          let orderBy = _.orderBy(filter, [ --}}{{--            'position', --}}{{--            'name', --}}{{--          ]); --}}{{--          console.log(orderBy, 0) --}}{{--          this.clone = [...orderBy]; --}}{{--          console.log(orderBy, 1) --}}{{--          // console.log(orderBy,2) --}}{{--          // const copyParent = {...this.parentCategory}; --}}{{--          // copyParent.name = 'بازگشت'; --}}{{--          if (this.back) { --}}{{--          this.back = false; --}}{{--          } --}}{{--          console.log(orderBy, 3) --}}{{--        } --}}{{--        else { --}}{{--          let orderBy = this.clone; --}}{{--          console.log(orderBy, 4) --}}{{--        } --}}{{--        console.log(orderBy, 5) --}}{{--        if (orderBy) { --}}{{--          return orderBy; --}}{{--        } --}}{{--        else { --}}{{--          return this.clone --}}{{--        } --}}{{--        // return orderBy.unshift(); --}}{{--      }, --}}{{--    }, --}}{{--  }) --}}{{--  // Vue.component("todo_item", { --}}{{--  //   props: ["todo_item_prop"], --}}{{--  //   template: `<li v-bind:class="{ strike: todo_item_prop.done }"> --}}{{--  //            @{{ todo_item_prop.text }} --}}{{--  //   </li>`, --}}{{--  // }) --}}{{-- </script> --}}{{-- @endsection --}}
