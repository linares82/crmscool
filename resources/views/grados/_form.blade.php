                <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif">
                       <label for="nivel_id-field">Nivel</label>
                       {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                       @if($errors->has("nivel_id"))
                        <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                          <label for="plantel_id-field">Plantel</label>
                          {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                          @if($errors->has("plantel_id"))
                            <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                          @endif
                    </div>