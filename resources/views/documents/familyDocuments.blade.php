@include('components.header', ['page_title' => 'خطابات اسرة الشهيد '])

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
              <a href="{{ route('families.show', $family->id) }}"> اسرة الشهيد {{ $family->martyr->name}} </a>
              /
            </li>
            <li  class="breadcrumb-item active">خطابات</li>
          </ol>
        </nav>

        <hr />

        <div class="d-flex justify-content-between align-items-center px-3">
        <h4> خطابات اسرة الشهيد {{ $family->martyr->name}} </h4>
          <a href="{{ route('documents.create', $family->id) }}" class="btn btn-primary active">
            <i class="fa fas-file-plus"></i>
            اضافة خطاب
          </a>
        </div>
        <hr />

        @if($family->documents->isNotEmpty())
          <h6 class="pb-1 mb-4 text-muted">الخطابات</h6>
        @else
          <h6 class="pb-1 mb-4 text-muted">لا توجد خطابات بعد</h6>
        @endif
        <x-alert/>
              <div class="row row-cols-1 row-cols-md-3 g-6 mb-6">
                @foreach ($family->documents as $doc)
                  <div class="col">
                  <div class="card h-100">
                    <a href="{{ asset("uploads/documents/{$doc->storage_path}") }}">
                      <img class="card-img-top" src='{{ asset("uploads/documents/{$doc->storage_path}") }}' alt="{{ $doc->type }}" />
                    </a>
                    <div class="card-body">
                      <h5 class="card-title">{{ $doc->type }}</h5>
                      <span class="text-secondary">ملاحظات</span>
                      <p class="card-text text-secondary mt-2">
                        {{ $doc->notes ?? 'لا يوجد'}}
                      </p>
                      <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-success fa-sm p-1">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="{{ route('documents.delete', $doc->id) }}" class="btn btn-danger fa-sm p-1">
                        <i class="fas fa-trash"></i>
                      </a>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>

            
    </div>

  </div>

  @include('components.footer')