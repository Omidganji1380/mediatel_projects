{{--
     <div class="col-md-12">
      <!-- Confirm Ad Submit - Step 3 -->
      <form class="ad_publish">
       <div class="loading"
            style="display: none;">
        <div class="loader-show"></div>
       </div>
       <div id="publish-charsoogh-response">
        <div class="alert alert-success"
             role="alert"><i class="fa fa-check-circle"
                             aria-hidden="true"></i> آگهی شما با موفقیت ثبت شده و پس از بررسی و تأیید مدیریت در سایت منتشر
         خواهد شد.
        </div>
        <?php
        $showGateway = true;
        ?>
        @if ($message = Session::get('success'))
         <div class="w3-panel w3-green w3-display-container">
          <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-green w3-large w3-display-topright">&times;</span>
          <p>{!! $message !!}</p>
         </div>
         <?php
         $showGateway = false;
         Session::forget('success'); ?>
        @endif

        @if ($message = Session::get('error'))
         <div class="w3-panel w3-red w3-display-container">
          <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-red w3-large w3-display-topright">&times;</span>
          <p>{!! $message !!}</p>
         </div>
         <?php
         $showGateway = true;
         Session::forget('error'); ?>
        @endif

        @if ($showGateway)
         <div id="coupon_load"
              class="loading">
          <div class="loader-show"></div>
         </div>
         <table class="table table-bordered table-hover upgrade-table">
          <input value="7891"
                 type="hidden"
                 id="upgrade_ad_id">
          <input value="663"
                 type="hidden"
                 id="user_id">
          <input value="313"
                 type="hidden"
                 id="category_id">
          <thead>
          <tr>
           <th scope="col">نام</th>
           <th scope="col">مبلغ</th>
           <th scope="col hidden-responsive">توضیحات</th>
           <th scope="col">پرداخت</th>
          </tr>
          </thead>
          <tbody>
          <tr>
           <th scope="row"
               id="name"><i class="fa fa-star"
                            aria-hidden="true"></i> آگهی ویژه
           </th>
           <td id="price">5,000$</td>
           <td id="detail">آگهی شما با برچسب آگهی ویژه نشان داده می‌شود. این امکان علاوه بر ایجاد تمایز ظاهری و جلب توجه
            بیشتر برای آگهی شما، شرایط نمایش در دسته بندی آگهی‌های ویژه را فراهم می‌سازد.
           </td>
           <td>
            <a wire:click.prevent="pay"
               id="featured_payment"
               class="btn btn-success small upgrade_ads">پرداخت</a>
           </td>
          </tr>
          <tr>
           <td colspan="4"
               class="copon_discount">
            <span id="have_copon"
                  style="display: none;"><i class="fa fa-ticket"
                                            aria-hidden="true"></i> کد تخفیف دارید؟</span>
            <div class="copon_div_display"
                 style="display: block;">
             <span id="discount_title">
              کد تخفیف </span>
             <span id="discount_code">
              <input type="text"

                     name="copon"
                     class="copon_code_entered">
              <a href="#"
                 id="premium_category_payment"
                 class="btn btn-info small apply_copon">اعمال</a>
              <div class="final_result">
               <p id="copon_response"></p>
               <p class="final_result_show"></p>
              </div>
             </span>
            </div>
           </td>
          </tr>
          </tbody>
         </table>

        @endif
       </div>
      </form>
     </div> --}}
<div class="col-12 col-lg-11 m-auto">
    <?php
    use Akaunting\Money\Money;
    $showGateway = true;
    ?>
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">{!! $message !!}</div>
        <?php
        $showGateway = false;
        Session::forget('success'); ?>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">{!! $message !!}</div>
        <?php
        $showGateway = true;
        Session::forget('error'); ?>
    @endif



    @if ($showGateway)
        <div class="table-responsive  pt-3">
            <table class="table table-bordered">
                <thead class="">
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">مبلغ</th>
                        <th scope="col">توضیحات</th>
                        <th scope="col">پرداخت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listPrice as $key => $item)
                        <tr class="bg-white">
                            <th scope="row">{!! $item['name'] !!}</th>
                            <td>
                                {{ Money::USD($item['price'], true) }}
                                <br>
                                @if ($discount?->percent)
                                    با
                                    {{ $discount?->percent }}% تخفیف
                                @endif
                                @if ($discount?->amount)
                                    <br> با
                                    <span dir="ltr">{{ Money::USD($discount?->amount, true) }}</span> تخفیف
                                    <br>
                                @endif
                                مجموع: <span dir="ltr">{{ Money::USD($item['total'], true) }}</span>
                            </td>
                            <td>{!! $item['description'] !!}</td>
                            <td>
                                <button class="btn btn-success" wire:click.prevent="pay('{{ $key }}')">پرداخت
                                </button>
                                <div wire:loading wire:target="pay" class=" m-4 spinner-border text-secondary"
                                    role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-white">
                        <td colspan="4">
                            <form action="" class="d-flex align-items-center justify-content-end">
                                <label for="" class="me-3">کد تخفیف</label>
                                <input wire:model="discountCode" type="text" class="form-control m-0">
                                <button class="btn btn-primary m-0" wire:click.prevent="checkDiscount">اعمال
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
