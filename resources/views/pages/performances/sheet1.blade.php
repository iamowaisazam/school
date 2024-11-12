<?php 

   $social_behavior = isset($model) ? json_decode($model->social_behavior) : [];
   $personal_habits = isset($model) ? json_decode($model->personal_habits) : [];


    $mon = 0;
    $tue = 0;
    $wed = 0;
    $thu = 0;
    $fri = 0;
    $sat = 0;
    $sun = 0;


    
?>

<div class="row">
<div class="col-12">
    <table class="tarbiya table" >
        <thead>
            <tr>
                <th>#</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
                <th>Sun</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>SOCIAL BEHAVIOR</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach (App\Enums\Behavior::DATA['social_behavior'] as $key => $item)
                <tr>
                    <td>{{$item['name']}}
                        <input type="hidden" name="social_behavior[{{$key}}][name]" value="" />
                    </td>
                    <td>
                        <input name="social_behavior[{{$key}}][mon]" 
                       @if(isset($social_behavior[$key]))
                       @php $mon += App\Enums\Behavior::cc($social_behavior[$key]->mon); @endphp 
                        value="{{$social_behavior[$key]->mon}}" 
                       @endif />
                    </td>
                    <td>
                        <input name="social_behavior[{{$key}}][tue]" 
                        
                        @if(isset($social_behavior[$key])) 
                        @php $tue += App\Enums\Behavior::cc($social_behavior[$key]->tue); @endphp 
                        value="{{$social_behavior[$key]->tue}}" @endif />
                    </td>
                    <td>
                        <input name="social_behavior[{{$key}}][wed]" 
                        @if(isset($social_behavior[$key])) 
                        @php $wed += App\Enums\Behavior::cc($social_behavior[$key]->wed); @endphp 
                        value="{{$social_behavior[$key]->wed}}" @endif />
                    </td>
                    <td>
                        <input name="social_behavior[{{$key}}][thu]" 
                        @if(isset($social_behavior[$key]))  
                        @php $thu += App\Enums\Behavior::cc($social_behavior[$key]->thu); @endphp 
                        value="{{$social_behavior[$key]->thu}}" @endif 
                        />
                    </td>
                    <td>
                        <input name="social_behavior[{{$key}}][fri]" 
                        @if(isset($social_behavior[$key]))  
                        @php $fri += App\Enums\Behavior::cc($social_behavior[$key]->fri); @endphp 
                        value="{{$social_behavior[$key]->fri}}" @endif />
                    </td>
                    <td>
                        <input name="social_behavior[{{$key}}][sat]" 
                        @if(isset($social_behavior[$key])) 
                        @php $sat += App\Enums\Behavior::cc($social_behavior[$key]->sat); @endphp 
                        value="{{$social_behavior[$key]->sat}}" @endif />
                    </td>
                    <td>
                        <input name="social_behavior[{{$key}}][sun]" 
                        @if(isset($social_behavior[$key])) 
                        @php $sun += App\Enums\Behavior::cc($social_behavior[$key]->sun); @endphp 
                        value="{{$social_behavior[$key]->sun}}" @endif />
                    </td>
                </tr>
            @endforeach

            <tr>
                <th>PERSONAL HABITS</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach (App\Enums\Behavior::DATA['personal_habits'] as $key => $item)
    
                <tr>
                    <td>{{$item['name']}}
                        <input type="hidden" name="personal_habits[{{$key}}][name]" value="" />
                    </td>
                    <td>
                        <input name="personal_habits[{{$key}}][mon]" 
                       @if(isset($social_behavior[$key]))
                       @php $mon += App\Enums\Behavior::cc($personal_habits[$key]->mon); @endphp 
                        value="{{$personal_habits[$key]->mon}}" 
                       @endif />
                    </td>
                    <td>
                        <input name="personal_habits[{{$key}}][tue]" 
                        
                        @if(isset($personal_habits[$key])) 
                        @php $tue += App\Enums\Behavior::cc($personal_habits[$key]->tue); @endphp 
                        value="{{$personal_habits[$key]->tue}}" @endif />
                    </td>
                    <td>
                        <input name="personal_habits[{{$key}}][wed]" 
                        @if(isset($personal_habits[$key])) 
                        @php $wed += App\Enums\Behavior::cc($personal_habits[$key]->wed); @endphp 
                        value="{{$personal_habits[$key]->wed}}" @endif />
                    </td>
                    <td>
                        <input name="personal_habits[{{$key}}][thu]" 
                        @if(isset($personal_habits[$key]))  
                        @php $thu += App\Enums\Behavior::cc($personal_habits[$key]->thu); @endphp 
                        value="{{$personal_habits[$key]->thu}}" @endif 
                        />
                    </td>
                    <td>
                        <input name="personal_habits[{{$key}}][fri]" 
                        @if(isset($personal_habits[$key]))  
                        @php $fri += App\Enums\Behavior::cc($personal_habits[$key]->fri); @endphp 
                        value="{{$personal_habits[$key]->fri}}" @endif />
                    </td>
                    <td>
                        <input name="personal_habits[{{$key}}][sat]" 
                        @if(isset($personal_habits[$key])) 
                        @php $sat += App\Enums\Behavior::cc($personal_habits[$key]->sat); @endphp 
                        value="{{$personal_habits[$key]->sat}}" @endif />
                    </td>
                    <td>
                        <input name="personal_habits[{{$key}}][sun]" 
                        @if(isset($personal_habits[$key])) 
                        @php $sun += App\Enums\Behavior::cc($personal_habits[$key]->sun); @endphp 
                        value="{{$personal_habits[$key]->sun}}" @endif />
                    </td>
                </tr>
            @endforeach

            <tr>
                <th>Score:</th>
                <td>{{$mon}}</td>
                <td>{{$tue}}</td>
                <td>{{$wed}}</td>
                <td>{{$thu}}</td>
                <td>{{$fri}}</td>
                <td>{{$sat}}</td>
                <td>{{$sun}}</td>
            </tr>
            <tr>
                <th>Grading Key:</th>
                <td colspan="7"  >
                    <div class="d-flex justify-content-between" >
                        <span>E = Excellent</span>
                        <span>G = Good</span>
                        <span>R = Average</span>
                        <span>B = Below Average </span>
                        <span> N = Needs Improvement</span>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Total:</th>
                <td colspan="7">
                    {{ $mon + $tue + $wed  + $thu + $fri + $sat + $sun }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>