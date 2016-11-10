@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Edit User</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container container-alt">
                <div class="block-header">
                    <h2>User Profile</h2>
                    <ul class="actions">
                        <li class="dropdown">
                            <a href="" data-toggle="dropdown">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="{{ url('admin/user/' . $data['id'] . '/edit') }}"><i class="zmdi zmdi-refresh-alt pd-r-5"></i> Refresh User</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="card" id="profile-main">
                    @include('backend.user.partials.sidebar')
                    <div class="pm-body clearfix">
                        <ul class="tab-nav tn-justified">
                            <li class="{{ Route::is('admin.user.edit') ? 'active' : '' }}">
                                <a href="{{ url('admin/user/' . $data['id'] . '/edit') }}">Profile</a>
                            </li>
                            <li class="{{ Route::is('admin.user.privacy') ? 'active' : '' }}">
                                <a href="{{ url('/admin/user/' . $data['id'] . '/privacy') }}">Privacy</a>
                            </li>
                        </ul>
                        @if(Session::has('errors') || Session::has('success'))
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    @include('shared.errors')
                                    @include('shared.success')
                                </div>
                            </div>
                        @endif
                        <form class="keyboard-save" role="form" method="POST" id="userUpdate" action="{{ route('admin.user.update', $data['id']) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-key m-r-10"></i> Edit Role</h2>
                                </div>
                                <div class="pmbb-body p-l-30">
                                    <br>
                                    <div class="form-group">
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" name="role" id="role" value="0" @if (! \App\Models\User::isAdmin($data->role)) checked="checked" @endif>
                                            <i class="input-helper"></i>
                                            User
                                        </label>

                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" name="role" value="1" @if (\App\Models\User::isAdmin($data->role)) checked="checked" @endif>
                                            <i class="input-helper"></i>
                                            Administrator
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-equalizer m-r-10"></i> Edit Summary</h2>
                                </div>
                                <div class="pmbb-body p-l-30">
                                    @include('backend.user.partials.form.summary')
                                </div>
                            </div>

                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-account m-r-10"></i> Edit Basic Information</h2>
                                </div>
                                <div class="pmbb-body p-l-30">
                                    @include('backend.user.partials.form.basic-information')
                                </div>
                            </div>

                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-phone m-r-10"></i> Edit Contact Information</h2>
                                </div>
                                <div class="pmbb-body p-l-30">
                                    @include('backend.user.partials.form.contact-information')
                                </div>
                            </div>

                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-accounts m-r-10"></i> Edit Social Networks</h2>
                                </div>
                                <div class="pmbb-body p-l-30">
                                    @include('backend.user.partials.form.social-networks')
                                </div>
                                <div class="form-group m-l-30">
                                    <button type="submit" class="btn btn-primary btn-icon-text">
                                        <i class="zmdi zmdi-floppy"></i> Save
                                    </button>&nbsp;
                                    <button type="button" class="btn btn-danger btn-icon-text" data-toggle="modal" data-target="#modal-delete">
                                        <i class="zmdi zmdi-delete"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
    @include('backend.user.partials.modals.delete')
@stop

@section('unique-js')
    {!! JsValidator::formRequest('App\Http\Requests\UserUpdateRequest', '#userUpdate') !!}
    @include('backend.shared.components.profile-datetime-picker', ['format' => 'YYYY-MM-DD'])

    @if(Session::get('_updateUser'))
        @include('backend.partials.notify', ['section' => '_updateUser'])
        {{ \Session::forget('_updateUser') }}
    @endif

    @if(Session::get('_updatePassword'))
        @include('backend.partials.notify', ['section' => '_updatePassword'])
        {{ \Session::forget('_updatePassword') }}
    @endif
@stop