@include('components.header', ['page_title' => "تواصل مع اسر الشهداء"])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">

        <x-alert/>


        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item">
              <a href="{{ route('tazkiia.index') }}">التزكية الروحية </a>
              /
            </li>
            <li  class="mr-1 breadcrumb-item active">تواصل مع اسر الشهداء</li>
          </ol>
        </nav>

        <hr>


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> تواصل مع اسر الشهداء </h4>
        </div>
       <hr>

        <x-table>
          <x-slot:head>
            <th> اسرة الشهيد </th>
            <th>رقم الهاتف</th>
            <th>اتمام التواصل</th>
            <th>الحالة</th>
            <th>التقديري</th>
            <th>من  داخل المنظمة</th>
            <th>من  خارج المنظمة</th>
            <th>ملاحظات</th>
            <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>

         @if($coms->isNotEmpty())
			      @foreach($coms->loadMissing('family') as $communicate)
              <tr>
               <td>{{ $communicate->family->martyr->name }}</td>
               <td>{{ $communicate->phone }}</td>
               <td>{{ $communicate->isCom }}</td>
               <td>{{ $communicate->status }}</td>
               <td>{{ number_format($communicate->budget) }}</td>                
               <td>{{ number_format($communicate->budget_from_org) }}</td>
               <td>{{ number_format($communicate->budget_out_of_org) }}</td>
               <td>{{ $communicate->notes }}</td>
               <td>
                  <a href="{{ route('tazkiia.communicate.edit', $communicate->id) }}" class="btn btn-success p-2 fa-sm">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="{{ route('tazkiia.communicate.delete', $communicate->id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="fa fa-trash"></i>
                  </a>
              </td>
            </tr>
			     @endforeach
            @else
              <tr>
                <td colspan="9">لم يتم التواصل</td>
              </tr>
            @endif  
			
        </x-slot:body>

      </x-table>

        {{ $coms->links('vendor.pagination.bootstrap-5') }}
		
        </div>
      </div>
    </div>

  @include('components.footer')