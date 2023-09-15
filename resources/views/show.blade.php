@extends('layouts.app')

@section('title')
    Signoff {{ $signoffable->signoff_name }}
@endsection

@section('content')
    <x-andach-card title="Signoff">
        @if ($signoffable->isFullySignedOff())
            <p><b>This has been fully signed off.</b></p>
            <p>This has been signed off by {{ $signoffable->signoff->user->name }} at {{ $signoffable->signoff->first_signoff_timestamp }}.</p>
            @if ($signoffable->signoff->first_signoff_image)
                <img src="{{ $signoffable->signoff->first_signoff_image }}"/>
            @endif

            @if ($signoffable->signoff->isSecondSignoffRequired())
                <p>Second signoff by {{ $signoffable->signoff->userSecond->name }} at {{ $signoffable->signoff->second_signoff_timestamp }}.</p>
                @if ($signoffable->signoff->second_signoff_image)
                    <img src="{{ $signoffable->signoff->second_signoff_image }}"/>
                @endif
            @endif
        @elseif ($signoffable->isFirstSignedOff())
            <p><b>This has been signed off, but second signoff is required. Please drag your finger or use your mouse in the box below to sign off the item as needed.</b></p>
            <p>This has been signed off by {{ $signoffable->signoff->user->name }} at {{ $signoffable->signoff->first_signoff_timestamp }}.</p>

            <x-form :action="route('signoff.second-post', [$object, $id])" class="e-signpad">
                <x-form-input type="hidden" name="object" :value="$object" floating />
                <x-form-input type="hidden" name="id" :value="$id" floating />
                <x-andach-signature-pad/>
                <x-form-submit class="sign-pad-button-submit">Provide Second Signoff</x-form-submit>
            </x-form>
        @else
            <p><b>This has not been signed off. Please drag your finger or use your mouse in the box below to sign off the item as needed.</b></p>

            <x-form :action="route('signoff.first-post', [$object, $id])" class="e-signpad">
                <x-form-input type="hidden" name="object" :value="$object" floating />
                <x-form-input type="hidden" name="id" :value="$id" floating />
                <x-andach-signature-pad/>
                <x-form-submit class="sign-pad-button-submit">Provide Signoff</x-form-submit>
            </x-form>
        @endif
    </x-andach-card>
@endsection
