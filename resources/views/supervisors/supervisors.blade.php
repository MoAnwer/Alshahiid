@include('components.header', ['page_title' => 'مشرفي الاسر'])

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
              <a href="{{route('home') }}">الرئيسية</a>
              /               
            </li>
            <li class="breadcrumb-item active mx-1" >
             المشرفين
            </li>
          </ol>
        </nav>

        <hr />

        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>مشرفي الاسر</h3>

          <div class="d-flex">
            <a class="btn btn-primary active" href="{{ route('supervisors.create')}}" >
              <i class="bi bi-plus-circle ml-2"></i>
              اضافة مشرف
            </a>

           @if (request()->query('show') != 'true')
              <a class="btn btn-success active mx-1" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل المشرفين

              </a>
            @else
              <a class="btn btn-info active mx-1" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x-circle ml-2"></i>
                إخفاء كل المشرفين

              </a>
            @endif
               {{-- Show btns --}}
          @if(request()->query('show') == 'true' || request('search'))
            @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
              <a class="btn btn-info active  mr-2" href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
                <i class="bi bi-eye-slash ml-2"></i>
                إخفاء ازرار الأسر و العمليات
              </a>
            @else
              <a class=" mr-2 btn btn-success active " href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }}" >
                <i class="bi bi-eye ml-2"></i>
                  عرض ازرار الأسر و العمليات
              </a>
            @endif
          @endif
          {{--/ Show btns --}}

          <button class="mx-4 btn btn-primary active" onclick="printContainer()">
                <i class="bi bi-printer ml-2"></i>
                طباعة 
              </button>


          </div>

        </div>

        <x-alert />


        <hr>


          <div class="search-form px-3">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">

            <input type="hidden" name="show" value="true" />
              
              <div class="col-6">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="name" @selected(request('search') == 'name')>اسم المشرف</option>
                      <option value="phone" @selected(request('search') == 'phone')>رقم هاتف المشرف</option>
                    </select>
                  </div>
              </div>

              <div class="col-5">
                <label>حقل البحث: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

               <div class="col-1 mt-3 d-flex align-items-center">
                <button class="btn py-3 px-2 btn-primary active form-control ml-2" title="بحث">
                  <i class="bi bi-search"></i>
                </button>
                <a class="btn py-3 px-2 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button"></i>
                </a>
              </div>

              
            </form>

            </div>
        </div> {{-- search form --}}


      @if (request()->query('show') == 'true')

      <div id="printArea">

        <x-table>
          <x-slot:head>
            <th>اسم المشرف</th>
            <th>رقم الهاتف</th>
            <th>عدد الاسر المشرف عليها</th>

            @if (request()->query('hiddenNotesAndActions') == 'true' || is_null(request()->query('hiddenNotesAndActions')))
              <th>قائمة الاسر</th>
              <th>عمليات</th>
              @endif
          </tr>

            
          </x-slot:head>

        <x-slot:body>
          @forelse ($supervisors as $supervisor)
              <tr>
                <td>{{ $supervisor->name }}</td>
                <td>{{ $supervisor->phone }}</td>
                <td>{{ $supervisor->families_count }}</td>
                
                @if (request()->query('hiddenNotesAndActions') == 'true' || is_null(request()->query('hiddenNotesAndActions')))
                  <td>
                  @if ($supervisor->families_count > 0)
                    <a href="{{ route('supervisors.families', $supervisor->id) }}" class="btn btn-primary active p-1 px-2">الاسر</a>
                  @else
                    لا توجد اسر
                  @endif
                </td>
                <td>
                  <a href="{{ route('supervisors.edit', $supervisor->id) }}" class="btn btn-success px-2">
                    <i class="bi bi-pen fa-sm"></i>
                  </a>
                  <a href="{{ route('supervisors.delete', $supervisor->id) }}" class="btn btn-danger px-2">
                    <i class="bi bi-trash-fill" title="حذف""></i>
                  </a>
                </td>
                @endif
                
              </tr>
              @empty
                <tr>
                  <td colspan="5">لايوجد مشرفون </td>
                </tr>
            @endforelse

            <caption>
              قائمة مشرفي الاسر 
            </caption>
          </x-slot:body>
        </x-table>

      {{ $supervisors->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5')  }}
      <hr>
        عدد المشرفين  الكلي  : <b>{{ $supervisors->total() }}</b>

    </div>

      @else
            <div class="text-center p-5 mx-auto my-5">
              <h3>ادخل اسم المشرف في حقل البحث لعرضه, او اضغط على عرض كل المشرفين</h3>
            </div>
        @endif

      </div>

    </div>



  @include('components.footer')