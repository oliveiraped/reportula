@extends('_layouts.default')
@section('main')

<div class="row-fluid">
    <div class="span12 box-content">
        <div class="span3 box-content breadcrumb">
            {{ Former::open_vertical('jobs', 'post', array('class' => 'form-inline')) }}
                {{ Form::hidden('start', $start, array("id"=>"start")) }}
                {{ Form::hidden('end', $end, array("id"=>"end")) }}
                {{ Form::hidden('type', $type, array("id"=>"type")) }}
                {{ Former::select('Job')->label('Job Selected')->options($jobSelectBox, $job)->id('job')->style("width:100%"); }}
                {{ Former::text('date')->prepend('<i class="icon-fam-calendar-add"></i>')->placeholder('Select Date')->required()->id('date')->name('date'); }}
                {{Former::submit( 'Search ')->class('btn btn-primary pull-right btn-info') }}
            {{Former::close();}}
            <hr>
            <table id="stats" class="" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"><strong>Job Stats</strong></td>
                    </tr>
                    <tr>
                        <td><a href="#" class="" onclick="jobsTable('terminated');"><i class="icon-fam-accept"></i> Terminated Jobs</a></td>
                        <td><span class="label label-success">{{ $terminatedJobs }}</span>
                    </tr>
                     <tr>
                        <td><a href="#" class="" onclick="jobsTable('error');"><i class="icon-fam-delete"></i> Jobs With Errors </a></td>
                        <td><span class="label label-important">{{ $errorJobs }}</span> </td>
                    </tr>
                    <tr>
                        <td><a href="#" class="" onclick="jobsTable('running');"><i class="icon-fam-database-save"></i>
                                Running Jobs </a>
                            </td>
                            <td><span class="label label-warning"> {{ $runningJobs }}</span></td>
                    </tr>
                    <tr>
                         <td>
                            <a href="#" class="" onclick="jobsTable('watting');">
                                <i class="icon-fam-database-link"></i> Watting Jobs </a></td>
                        <td> <span class="label label-inverse"> {{ $wattingJobs }} </span></td>

                    </tr>
                    <tr>
                        <td><a href="#" class="" onclick="jobsTable('cancel');"><i class="icon-fam-database-edit"></i> Canceled Jobs </a></td>
                        <td><span class="label label-inverse"> {{ $cancelJobs }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="icon-fam-database-table"></i> Transfered Bytes</td>
                        <td><strong>{{ $nTransBytes }}</strong></td>
                    </tr>
                    <tr>
                        <td><i class="icon-fam-database-refresh"></i> Transfered Files </td>
                        <td><strong>{{ $nTransFiles }} </strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><br></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong> Okay Jobs :</strong> <?=$terminatedJobs ?>/<?=$terminatedJobs+$errorJobs ?>
                         <div class="progress progress-striped progress-success active">
                                <div style="width: {{ intval($graphOkJob).'%' }} " class="bar"></div>

                        </div>
                    </tr>
                    <tr>
                        <td colspan="2"><strong> Failed Jobs </strong><?=$errorJobs ?>/<?=$terminatedJobs+$errorJobs ?>
                        <div style="margin-bottom: 9px;" class="progress progress-danger progress-striped">
                            <div style="width: {{ intval($graphFailedJob).'%' }}" class="bar"></div>
                        </div>
                    </tr>
                     @if ( is_array($filesinclude))
                        <tr>
                            <td colspan="2"><strong> Included Files & Folders </strong></td>
                        </tr>
                        <tr class="success" >
                            <td colspan="2">
                                <ul>
                                    @foreach ($filesinclude as $include)
                                        <li>{{ $include->file }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                    @if ( is_array($filesexclude))
                        <tr>
                            <td colspan="2"><strong> Excluded Files & Folders </strong><td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <ul>
                                    @foreach ($filesexclude as $exclude)
                                         <li>{{ "\t".$exclude->file }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
               </tbody>
            </table>
        </div>
    <div class="span9 box-content">
        <table id="jobsTable" class="dashboardTable table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th><center>Job ID </center></th>
                    <th><center>Started Time</center></th>
                    <th><center>Endend Time</center></th>
                    <th><center>Volume Name</center></th>
                    <th><center>Job Level</center></th>
                    <th><center>Bytes</center></th>
                    <th><center>Files</center></th>
                    <th><center>Status</center></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row-fluid">
    <div class="span12 box-content">
        <div class="span6 box-content breadcrumb">
            <div id="bytesGraphs" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
        </div>
        <div class="span6 box-content breadcrumb">
            <div id="filesGraphs" style="min-width: 100%;  height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>

<script>
/* Code For The Graphs */
var chart;
var legend;
<?php echo "var chartDataFiles = ". $graphFiles . ";\n";
      echo "var chartDataBytes = ". $graphBytes . ";\n";
?>

</script>

@endsection