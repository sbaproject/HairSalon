@extends('master')
@section('title','Login')
@section('menu')
@parent
@endsection
@section('content')
<div class="templatemo-content-container">
          <div class="templatemo-content-widget no-padding">
            <div class="panel panel-default table-responsive">
              <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                  <tr>
                    <td><a href="" class="white-text templatemo-sort-by">ID <span class="caret"></span></a></td>
                    <td><a href="" class="white-text templatemo-sort-by">Month <span class="caret"></span></a></td>
                    <td><a href="" class="white-text templatemo-sort-by">Total price <span class="caret"></span></a></td>
                    <td><a href="" class="white-text templatemo-sort-by">From date <span class="caret"></span></a></td>
                    <td><a href="" class="white-text templatemo-sort-by">to date <span class="caret"></span></a></td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                  
                  <tr>
                    <td><?php echo "Đang phát triển"; ?></td>
                    <td><a href="" class="templatemo-edit-btn">Edit</a>
                   <a href="" class="templatemo-edit-btn">Delete</a></td>
                  </tr>   
          
                </tbody>
              </table>    
            </div>                          
          </div> 
@endsection