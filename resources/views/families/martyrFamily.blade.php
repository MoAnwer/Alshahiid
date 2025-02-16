@include('components.header', ['page_title' => 'بيانات اسرة  الشهيد ' . $family->martyr->name])

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
            <li class="breadcrumb-item active " >
              اسرة الشهيد {{ $family->martyr->name}}
            </li>
          </ol>
        </nav>

        <x-alert/>

        <hr/>

        <div class="d-flex justify-content-between align-items-center px-3">
          <div>
            <h4>اسرة الشهيد {{ $family->martyr->name }} <span class="text-primary text-bold">[ {{ $family->category }} ]</span></h4>
            <span>عدد افراد الاسرة {{ $family->family_size }} , و تم اضافة {{ $family->familyMembers->count() }} منهم الى النظام</span>
            <div>
              <span>[تم اضافة الاسرة الى النظام في  {{ date('Y-m-d', strtotime($family->created_at) )}} ]</span>
              <a href="{{ route('families.edit', $family->id) }}" class="btn btn-success p-2 fa-sm">
              <i class="bi bi-pen" title="تعديل"></i>
            </a>
            <a href="{{ route('families.delete', $family->id) }}" class="btn btn-danger p-2 fa-sm">
              <i class="bi bi-trash-fill" title="حذف"></i>
            </a>
            </div>

          </div>
          @if ($family->familyMembers->count() < $family->family_size)
            <a class="btn btn-primary active" href="{{ route('familyMembers.create', $family->id) }}">اضافة فرد جديد</a>
          @endif
        </div>

        <x-table>
          <x-slot:head>
            <th>#</th>
            <th>اسم</th>
            <th>النوع</th>
            <th>العمر</th>
            <th>العلاقة</th>
            <th>الرقم الوطني</th>
            <th>الصورة الشخصية</th>
            <th>رقم التأمين الصحي</th>
            <th>بداية التأمين الصحي</th>
            <th>نهاية التأمين الصحي</th>
            <th>رقم الهاتف</th>
            <th>عمليات</th>
          </x-slot:head>

          <x-slot:body>
          @if($family->familyMembers->isNotEmpty())
            @foreach($family->familyMembers as $familyMember)
              <tr>
                <td>{{ $familyMember->id }}</td>
                <td>{{ $familyMember->name }}</td>
                <td>{{ $familyMember->gender }}</td>
                <td>{{ $familyMember->age }}</td>
                <td>{{ $familyMember->relation }}</td>
                <td>{{ $familyMember->national_number }}</td>

                <td>
                  @if(!is_null($familyMember->personal_image))
                  <a href="{{ url("uploads/images/{$familyMember->personal_image}") }}" target="_blank">
                    <img src="{{ url("uploads/images/{$familyMember->personal_image}") }}" width="50"/>
                  </a>
                  @else
                   لا توجد صورة
                  @endif
                </td>
                <td>{{ $familyMember->health_insurance_number }}</td>
                <td>{{ $familyMember->health_insurance_start_date }}</td>
                <td>{{ $familyMember->health_insurance_end_date }}</td>
                <td>{{ $familyMember->phone_number }}</td>
                <td>
                    <a href="{{ route('familyMembers.edit', $familyMember->id) }}" class="btn btn-success py-1 px-2 fa-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                    </a>
                    <a href="{{ route('familyMembers.delete', $familyMember->id) }}" class="btn btn-danger py-1 px-2 fa-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                    </a>
					          <a href="{{ route('familyMembers.show', $familyMember->id) }}" class="btn btn-info py-1 px-2 fa-sm">
                      <i class="bi bi-person-fill"></i>
                    </a>
                  </td>
              </tr>
            @endforeach

            @else
              <tr>
                <td colspan="12"> 
                  لا يوجد افراد
                  <b> [ مطلوب افراد {{ $family->family_size }} ]</b>
                </td>
              </tr>
            @endif
          </x-slot:body>
        </x-table>

      <hr />

      {{-- Supervisor --}}
      <div class="d-flex justify-content-between align-items-center px-3">
        <h4>المشرف على اسرة الشهيد {{ $family->martyr->name }}</h4>
      </div>

      <x-table>
          <x-slot:head>
            <th>اسم المشرف</th>
            <th>رقم الهاتف</th>
            <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
          @isset($family->supervisor)              
              <tr>
                <td>{{ $family->supervisor->name }}</td>
                <td>{{ $family->supervisor->phone }}</td>
                <td>
                  <a href="{{ route('families.editSupervisor', $family->id) }}" class="btn btn-success px-2">
                    <i class="bi bi-pen fa-sm"></i>
                  </a>
                  <a href="{{ route('families.deleteSupervisor', $family->id) }}" class="btn btn-danger px-2">
                    <i class="bi bi-trash-fill" title="حذف""></i>
                  </a>
                </td>
              </tr>
            @else
              <tr>
                <td colspan="5">
                  <a href="{{ route('families.createSupervisor', $family->id) }}" class="btn btn-success">
                    <i class="fas fa-plus ml-2"></i>
                    إضافة مشرف
                  </a>
                </td>
              </tr>
            @endisset

          </x-slot:body>
        </x-table>

      {{--/ Suprvisor --}}

      <!-- Address -->
      <hr>

      <div class="d-flex justify-content-between align-items-center px-3">
        <h4>مكان سكن الاسرة</h4>
        <a class="btn btn-primary active " href="{{ route('address.create', $family->id) }}">اضافة مسكن جديد</a>
      </div>
       <x-table>
          <x-slot:head>
            <th>القطاع</th>
            <th>المحلية</th>
            <th>الحي</th>
            <th>نوع المسكن</th>
            <th>عمليات</th>
          </x-slot:head>

          <x-slot:body>
          @if($family->addresses->isNotEmpty())
			      @foreach($family->addresses as $address)
              <tr>
               <td>{{ $address->sector }}</td>
               <td>{{ $address->locality }}</td>
               <td>{{ $address->neighborhood}}</td>                
               <td>{{ $address->type }}</td>
               <td>
                  <a href="{{ route('address.edit', $address->id) }}" class="btn btn-success p-2 fa-sm">
                    <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('address.delete', $address->id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
              </td>
            </tr>
			     @endforeach
            @else
              <tr>
                <td colspan="5">لا يوجد سكن</td>
              </tr>
            @endif
          </x-slot:body>
        </x-table>

        <hr>

        
      <div class="d-flex justify-content-between align-items-center px-3">
        <h4>التواصل مع اسرة الشهيد {{ $family->martyr->name }}</h4>
        <a class="btn btn-primary active " href="{{ route('tazkiia.communicate.create', $family->id) }}">اضافة</a>
      </div>
       <x-table>
          <x-slot:head>
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
          @if($family->communicate->isNotEmpty())
			      @foreach($family->communicate as $communicate)
              <tr>
               <td>{{ $communicate->phone }}</td>
               <td>{{ $communicate->isCom }}</td>
               <td>{{ $communicate->status }}</td>
               <td>{{ number_format($communicate->budget) }}</td>                
               <td>{{ number_format($communicate->budget_from_org) }}</td>
               <td>{{ number_format($communicate->budget_out_of_org) }}</td>
               <td>{{ $communicate->notes }}</td>
               <td>
                  <a href="{{ route('tazkiia.communicate.edit', $communicate->id) }}" class="btn btn-success p-2 fa-sm">
                    <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('tazkiia.communicate.delete', $communicate->id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
              </td>
            </tr>
			     @endforeach
            @else
              <tr>
                <td colspan="8">لم يتم التواصل</td>
              </tr>
            @endif
          </x-slot:body>
        </x-table>

      <!--/ Address  -->

      <hr>
      <div class="row mb-3 py-3">

        <div class="col-sm-12 col-6  col-lg-3">
          <a href="{{ route('tazkiia.martyrDocs.index', $family->martyr->id) }}" target="_blank">
          <div class="card text-center py-3 border border-warning">
            <div class="card-body">
              <i class="bi bi-star-fill fs-1 text-warning mb-5"></i>
              <h5 class="card-title mb-3 mt-3"> توثيق سيرة الشهيد {{ $family->martyr->name }} </h5>
              <p class="card-text mb-3">السيرة الذاتية للشهيد</p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-lg-3 col-6 col-sm-12">

          <a href="{{ route('documents.show', $family->id) }}" target="_blank">
          <div class="card text-center py-3 border border-info">
            <div class="card-body">
              <i class="bi bi-file-pdf-fill fs-1 text-info mb-5"></i>
              <h5 class="card-title mb-3 mt-3"> خطابات اسرة </h5>
              <p class="card-text mb-3"> تأكيد الاستشهاد، الاعلام الشرعي، التوكيل ...</p>

              </div>
            </div>
          </a>

        </div>

        <div class="col-lg-3 col-6 col-sm-12">
          <a href="{{ route('families.socialServices', $family->id)}}" target="_blank">
          <div class="card text-center py-3 border border-danger">
            <div class="card-body">
              <i class="bi bi-person-hearts fs-1 text-danger mb-5"></i>
              <h5 class="card-title mb-3 mt-3"> الخدمات الاجتماعية </h5>
              <p class="card-text mb-3">الخدمات الاجتماعية </p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-lg-3 col-6 col-sm-12">
          <a href="{{ route('families.bails', $family->id)}}" target="_blank">
          <div class="card text-center py-3 border border-success">
            <div class="card-body">
              <i class="bi bi-cash-coin fs-1 text-success mb-5"></i>
              <h5 class="card-title mb-3 mt-3">  الكفالات الشهرية  </h5>
              <p class="card-text mb-3">الكفالات الشهرية  </p>
                </div>
              </div>
            </a>
        </div>
        
        </div>
      </div>      
    </div>

  @include('components.footer')