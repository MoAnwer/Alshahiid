@include('components.header', ['page_title' => 'الكفالات الشهرية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style2">
            <li class="breadcrumb-item">
              <a href="{{ route('martyrs.index') }}">الشهداء</a>
              /               
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('families.show', $family->id) }}">
                اسرة الشهيد {{ $family->martyr->name}}
              </a>
            </li>
            <li class="breadcrumb-item active" >
              الكفالات الشهرية
            </li>
          </ol>
        </nav>


      <hr/>
      <div class="d-flex justify-content-between align-items-center px-3">
        <h4>الكفالات الشهرية</h4>
        <a class="btn btn-primary active " href="{{ route('bails.create', $family->id) }}">اضافة كفالة جديدة</a>
      </div>

      <x-table>
        <x-slot:head>
          <th>#</th>
          <th>النوع</th>
          <th>الحالة</th>
          <th>الشهر</th>
          <th>المتكفل</th>
          <th>التقديري</th>
          <th>من  داخل المنظمة</th>
          <th>من  خارج المنظمة</th>
          <th>المبلغ المؤمن</th>
          <th>ملاحظات</th>
          <th>عمليات</th>
        </x-slot:head>

        <x-slot:body>
          @if ($family->bails->isNotEmpty())
            @foreach ($family->bails as $bail)
              <tr>
                <td>{{ $bail->id }}</td>
                <td>{{ $bail->type }}</td>
                <td>{{ $bail->status }}</td>
                <td>{{ date('m', strtotime($bail->created_at)) }}</td>
                <td>{{ $bail->provider }}</td>
                <td>{{ number_format($bail->budget) }}</td>
                <td>{{ number_format($bail->budget_from_org) }}</td>
                <td>{{ number_format($bail->budget_out_of_org) }}</td>
                <td>{{ number_format($bail->budget_out_of_org  + $bail->budget_from_org) }}</td>
                <td>{{ $bail->notes }}</td>
                <td>
                  <a href="{{ route('bails.edit', $bail->id) }}" class="btn btn-success p-2 fa-sm">
                      <i class="fa fa-edit"></i>
                  </a>
                  <a href="{{ route('bails.delete', $bail->id) }}" class="btn btn-danger p-2 fa-sm">
                      <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          @else
              <tr><td colspan="11">لا توجد كفالات بعد</td></tr>
          @endif

        </x-slot:body>
      </x-table>
        </div>

      </div>

      
  
    </div>

  @include('components.footer')