@include('components.header', ['page_title' => ' الكفالات الشهرية اسرة الشهيد' . $martyrName])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item">
              
                <a href="{{ route('home') }}">الرئيسية</a>
                /               
              </li>
              <li class="breadcrumb-item mx-1">
                <a href="{{ route('families.list') }}">قائمة اسر الشهداء</a>
              </li>

              <li class="breadcrumb-item ml-2">
                <a href="{{ route('families.show', request('family')) }}">
                  اسرة الشهيد {{ $martyrName}}
                </a>
              </li>
              <li class="breadcrumb-item active" >
                الكفالات الشهرية
              </li>
          </ol>
        </nav>

      <hr/>

      <div class="d-flex justify-content-between align-items-center px-3">
        <h4> الكفالات الشهرية لاسرة الشهيد {{ $martyrName}}  </h4>
        <a class="btn btn-primary active " href="{{ route('bails.create', request('family')) }}">اضافة كفالة جديدة</a>
      </div>

      <hr>

      <x-date-search-form>

        <x-slot:inputs>

            <div class="col-4">
                <label>نوع  الكفالة :</label>
                <div class="form-group">
                  <select name="type" class="form-select">
                     <option value="all" @selected(request('type') == 'all')>الكل</option>
                     <option value="مجتمعية" @selected(request('type') == 'مجتمعية' )>مجتمعية</option>
                     <option value="مؤسسية" @selected(request('type') == 'مؤسسية' )>مؤسسية</option>
                     <option value="المنظمة" @selected(request('type') == 'المنظمة' )>المنظمة</option>
                  </select>
                </div>
            </div>

            <div class="col-2">
                <label>حالة الخدمة :</label>
                <div class="form-group">
                  <select name="status" class="form-select">
                     <option value="all" @selected(request('status') == 'all')>الكل</option>
                     <option value="مطلوب" @selected(request('status') == 'مطلوب' )>مطلوب</option>
                     <option value="منفذ" @selected(request('status') == 'منفذ' )>منفذ</option>
                  </select>
                </div>
            </div>

            <div class="col-2">
              <div class="form-group">
                <label>المتكفل :</label>
                <select name="provider" class="form-select">
                    <option value="all" @selected(request('provider') == 'all')>الكل</option>
                    <option value="الحكومة"  @selected(request('provider') == 'الحكومة')>الحكومة</option>
                    <option value="ديوان الزكاة"  @selected(request('provider') == 'ديوان الزكاة')>ديوان الزكاة</option>
                    <option value="دعم شعبي"  @selected(request('provider') == 'عم شعبي')>دعم شعبي</option>
                    <option value="ايرادات المنظمة"  @selected(request('provider') == 'يرادات المنظمة')>ايرادات المنظمة</option>
                </select>
              </div>
            </div>

        </x-slot:inputs>

      </x-date-search-form>


      <x-table>
        <x-slot:head>
          <th>#</th>
          <th>النوع</th>
          <th>الحالة</th>
          <th>الشهر</th>
          <th>السنة</th>
          <th>المتكفل</th>
          <th>التقديري</th>
          <th>من  داخل المنظمة</th>
          <th>من  خارج المنظمة</th>
          <th>المبلغ المؤمن</th>
          <th>ملاحظات</th>
          <th>عمليات</th>
        </x-slot:head>

        <x-slot:body>
          @if ($bails->isNotEmpty())
            @foreach ($bails as $bail)
              <tr>
                <td>{{ $bail->id }}</td>
                <td>{{ $bail->type }}</td>
                <td>{{ $bail->status }}</td>
                <td>{{ date('m', strtotime($bail->created_at)) }}</td>
                <td>{{ date('Y', strtotime($bail->created_at)) }}</td>
                <td>{{ $bail->provider }}</td>
                <td>{{ number_format($bail->budget) }}</td>
                <td>{{ number_format($bail->budget_from_org) }}</td>
                <td>{{ number_format($bail->budget_out_of_org) }}</td>
                <td>{{ number_format($bail->budget_out_of_org  + $bail->budget_from_org) }}</td>
                <td>{{ $bail->notes }}</td>
                <td>
                  <a href="{{ route('bails.edit', $bail->id) }}" class="btn btn-success p-2 fa-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('bails.delete', $bail->id) }}" class="btn btn-danger p-2 fa-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          @else
            <tr><td colspan="12">لا توجد نتائج</td></tr>
          @endif

        </x-slot:body>

      </x-table>

      {{ $bails->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}

      <hr >

      <div class="card-body d-flex justify-content-between px-5">
         <div>
            اجمالي التقديري: 
            <code><b>{{ number_format($totalBudget) }}</b></code>
         </div>
          <div>
            اجمالي  من داخل المنظمة :
            <code><b>{{ number_format($totalBudgetFromOrg) }}</b></code>
         </div>

         <div>
            اجمالي من خارج المنظمة :
            <code><b>{{ number_format($totalBudgetOutOfOrg) }}</b></code>
         </div>

         <div>
            اجمالي    المبلغ المؤمن :
            <code><b>{{ number_format($totalMoney) }}</b></code>
         </div>
      </div>

      </div>

    </div>

  </div>

  @include('components.footer')