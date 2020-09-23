@extends('admin.layout')

@section('content')
<div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Posts</h4>
                        <a href="/post/create"><button type="button" class="btn btn-primary btn-fw btn-rounded">New Post</button></a>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Featured Image</th>
                              <th>Title</th>
                              <th>Status</th>
                              <th>Publishing date</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>INV-87239</td>
                              <td>Viola Ford</td>
                              <td>Paid</td>
                              <td>20 Jan 2019</td>
                              <td>$755</td>
                            </tr>
                            <tr>
                              <td>INV-87239</td>
                              <td>Dylan Waters</td>
                              <td>Unpaid</td>
                              <td>23 Feb 2019</td>
                              <td>$800</td>
                            </tr>
                            <tr>
                              <td>INV-87239</td>
                              <td>Louis Poole</td>
                              <td>Unpaid</td>
                              <td>25 Mar 2019</td>
                              <td>$463</td>
                            </tr>
                            <tr>
                              <td>INV-87239</td>
                              <td>Vera Howell</td>
                              <td>Paid</td>
                              <td>27 Mar 2019</td>
                              <td>$235</td>
                            </tr>
                            <tr>
                              <td>INV-87239</td>
                              <td>Allie Goodman</td>
                              <td>Unpaid</td>
                              <td>1 Apr 2019</td>
                              <td>$657</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection