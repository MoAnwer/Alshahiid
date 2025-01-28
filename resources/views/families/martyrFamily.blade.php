@include('components.header', ['page_title' => 'بيانات اسرة  الشهيد'])

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
            <li class="breadcrumb-item active" >
              اسرة الشهيد {{ $family->martyr->name}}
            </li>
          </ol>
        </nav>

        <x-alert/>

        <hr/>

        <div class="d-flex justify-content-between align-items-center px-3">
          <div>
            <h4>اسرة الشهيد {{ $family->martyr->name }}</h4>
            <span>عدد افراد الاسرة {{ $family->family_size }} , و تم اضافة {{ $family->loadMissing('familyMembers')->familyMembers->count() }} منهم الى النظام</span>
            
            <div>
              <a href="{{ route('families.edit', $family->id) }}" class="btn btn-success p-2 fa-sm">
              <i class="fa fa-edit"></i>
            </a>
            <a href="{{ route('families.delete', $family->id) }}" class="btn btn-danger p-2 fa-sm">
              <i class="fa fa-trash"></i>
            </a>
            </div>

          </div>
          @if ($family->loadMissing('familyMembers')->familyMembers->count() < $family->family_size)
            <a class="btn btn-primary active" href="{{ route('familyMembers.create', $family) }}">اضافة فرد جديد</a>
          @endif
        </div>

        <x-table>
          <x-slot:head>
            <th>اسم</th>
            <th>النوع</th>
            <th>العمر</th>
            <th>العلاقة</th>
            <th>الصورة الشخصية</th>
            <th>رقم التأمين الصحي</th>
            <th>بداية التأمين الصحي</th>
            <th>نهاية التأمين الصحي</th>
            <th>رقم الهاتف</th>
            <th>الرقم الوطني</th>
            <th>عمليات</th>
          </x-slot:head>

          <x-slot:body>
          @if($family->loadMissing('familyMembers')->familyMembers->count() > 0)
            @foreach($family->loadMissing('familyMembers')->familyMembers as $familyMember)
              <tr>
                <td>{{ $familyMember->name }}</td>
                <td>{{ $familyMember->gender }}</td>
                <td>{{ $familyMember->age }}</td>
                <td>{{ $familyMember->relation }}</td>
                <td>
                  @if(!is_null($familyMember->personal_image))
                  <a href="{{ url("uploads/images/{$familyMember->personal_image}") }}">
                    <img src="{{ url("uploads/images/{$familyMember->personal_image}") }}" width="50"/>
                  </a>
                  @else
                    -
                  @endif
                </td>
                <td>{{ $familyMember->health_insurance_number }}</td>
                <td>{{ $familyMember->health_insurance_start_date }}</td>
                <td>{{ $familyMember->health_insurance_end_date }}</td>
                <td>{{ $familyMember->phone_number }}</td>
                <td>{{ $familyMember->national_number }}</td>
                <td>
                    <a href="{{ route('familyMembers.edit', ['family' => $family->id, 'member' => $familyMember->id]) }}" class="btn btn-success p-2 fa-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('familyMembers.delete', $familyMember->id) }}" class="btn btn-danger p-2 fa-sm">
                      <i class="fa fa-trash"></i>
                    </a>
					          <a href="{{ route('familyMembers.show', $familyMember->id) }}" class="btn btn-info p-2 fa-sm">
                      <i class="fa fa-user"></i>
                    </a>
                  </td>
              </tr>
            @endforeach

            @else
              <tr>
                <td colspan="11"> 
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
                    <i class="fas fa-edit fa-sm"></i>
                  </a>
                  <a href="{{ route('families.deleteSupervisor', $family->id) }}" class="btn btn-danger px-2">
                    <i class="fas fa-trash fa-sm"></i>
                  </a>
                </td>
              </tr>
            @else
              <tr>
                <td colspan="5">
                  <a href="{{ route('families.createSupervisor', $family->id) }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
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
        <a class="btn btn-primary active " href="{{ route('address.create', $family) }}">اضافة مسكن جديد</a>
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
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="{{ route('address.delete', $address->id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="fa fa-trash"></i>
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

      <!--/ Address  -->

      <div class="row mb-3">

        <div class="col-md-6 col-lg-4">
          <div class="card text-center py-3">
            <div class="card-body">
              <i class="fas fa-file fs-1 text-info mb-4"></i>
              <h5 class="card-title mb-3"> خطابات اسرة </h5>
              <p class="card-text mb-3">خطابات تأكيد الاستشهاد و الاعلام الشرعي و التوكيل و قطعة الارض</p>
              <a href="{{ route('documents.show', $family->id) }}" class="btn btn-primary active">عرض الخطابات</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card text-center py-3">
            <div class="card-body">
              <i class="fas fa-tools fs-1 text-info mb-4"></i>
              <h5 class="card-title mb-3"> الخدمات الاجتماعية </h5>
              <p class="card-text mb-3">الخدمات الاجتماعية </p>
              <a href="{{ route('families.socialServices', $family->id)}}" class="btn btn-primary active">عرض</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card text-center py-3">
            <div class="card-body">
              <i class="fas fa-dollar-sign fs-1 text-info mb-4"></i>
              <h5 class="card-title mb-3">  الكفالات الشهرية  </h5>
              <p class="card-text mb-3">الكفالات الشهرية  </p>
              <a href="{{ route('families.bails', $family->id)}}" class="btn btn-primary active">عرض</a>
            </div>
          </div>
        </div>

        </div>

      </div>

      
  
    </div>

  @include('components.footer')