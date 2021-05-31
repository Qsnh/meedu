@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 py-10 lg:max-w-6xl lg:mx-auto">
        <div class="flex justify-center">
            <div class="w-full lg:w-96 bg-white p-5 shadow rounded">
                <form method="post" action="">
                    @csrf
                    @include('frontend.components.mobile', ['smsCaptchaKey' => 'mobile_bind'])
                    <div>
                        <button type="submit"
                                class="w-full rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                            {{__('绑定手机号')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection