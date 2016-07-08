@extends('layouts.main')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
            <li class="active">User Profile</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">User Profile <small> you are looking good...</small></h1>
        <!-- end page-header -->
        <!-- begin profile-container -->
        <div class="profile-container">
            <!-- begin profile-section -->
            <div class="profile-section">
                <!-- begin profile-left -->
                <div class="profile-left">
                    <!-- begin profile-image -->
                    <div class="profile-image">
                        <img src="{{ asset('assets/img/profile-cover.jpg') }}" />
                        <i class="fa fa-user hide"></i>
                    </div>
                    <!-- end profile-image -->
                </div>
                <!-- end profile-left -->
                <!-- begin profile-right -->
                <div class="profile-right">
                    <!-- begin profile-info -->
                    <div class="profile-info">
                        <!-- begin table -->
                        <div class="table-responsive">
                            <table class="table table-profile">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <h4>{{ $user->name }} <small></small></h4>
                                    </th>
                                </tr>
                                </thead>
                                @if($user->gamer)
                                <tbody>
                                    <tr class="highlight">
                                        <td class="field">Battle Tag</td>
                                        <td><a href="#">{{ $user->gamer->battletag }}</a></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Mobile</td>
                                        <td><i class="fa fa-mobile fa-lg m-r-5"></i> +1-(847)- 367-8924 <a href="#" class="m-l-5">Edit</a></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Home</td>
                                        <td><a href="#">Add Number</a></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Office</td>
                                        <td><a href="#">Add Number</a></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr class="highlight">
                                        <td class="field">About Me</td>
                                        <td><a href="#">Add Description</a></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Country/Region</td>
                                        <td>
                                            <select class="form-control input-inline input-xs" name="region">
                                                <option value="US" selected>United State</option>
                                                <option value="AF">Afghanistan</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AS">American Samoa</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="field">City</td>
                                        <td>Los Angeles</td>
                                    </tr>
                                    <tr>
                                        <td class="field">State</td>
                                        <td><a href="#">Add State</a></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Website</td>
                                        <td><a href="#">Add Webpage</a></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Gender</td>
                                        <td>
                                            <select class="form-control input-inline input-xs" name="gender">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="field">Birthdate</td>
                                        <td>
                                            <select class="form-control input-inline input-xs" name="day">
                                                <option value="04" selected>04</option>
                                            </select>
                                            -
                                            <select class="form-control input-inline input-xs" name="month">
                                                <option value="11" selected>11</option>
                                            </select>
                                            -
                                            <select class="form-control input-inline input-xs" name="year">
                                                <option value="1989" selected>1989</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="field">Language</td>
                                        <td>
                                            <select class="form-control input-inline input-xs" name="language">
                                                <option value="" selected>English</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                                @else
                                    This user is not an active gamer yet.
                                @endif
                            </table>
                        </div>
                        <!-- end table -->
                    </div>
                    <!-- end profile-info -->
                </div>
                <!-- end profile-right -->
            </div>
            <!-- end profile-section -->

        </div>
        <!-- end profile-container -->
    </div>
    <!-- end #content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
@endsection

