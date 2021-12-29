<div>
    @if($errors->any())
        <ul>
            {!! implode('', $errors->all('<li class="text-danger">:message</li>')) !!}
        </ul>
    @endif
    <div class="row">
        @forelse($sacs as $index => $sac)
            <div class="col-12">
                <hr class="m-1" style="border-bottom: 1.5px solid black;">
                <div class="row d-flex align-items-center m-0">
                    <input type="hidden"  name="sacs[{{$index}}][id]"    value="{{$sac['id']}}" />
                    <x-forms.input        name="sacs[{{$index}}][name]" :value="$sac['name']" label="Kisə adı"/>
                    <x-forms.input        name="sacs[{{$index}}][sac_count]"  :value="$sac['sac_count']" label="Kisə sayı"/>
                    <x-forms.input        name="sacs[{{$index}}][sac_weight]"  :value="$sac['sac_weight']" label="Kisə həcmi (kg)"/>
                    @if($action)
                        <div class="form-group col-12 col-md-1 mb-3 mb-md-0 mt-0 mt-md-3 pl-3 pl-md-0">
                            <button type="button" wire:click.prevent="removeSac({{$index}})" class="btn btn-outline-danger">
                                <i class='mdi mdi-close-circle'></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted my-2">Boşdur</p>
            </div>
        @endforelse
    </div>
    @if($action)
        <button type="button" class="btn btn-outline-success" wire:click.prevent="addSac"><i class='mdi mdi-plus'></i></button>
    @endif
</div>
