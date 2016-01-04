<?= '<?php' . PHP_EOL; ?>

namespace {{ config('api.transformer.namespace') }};

use {{ $subject->model }};
use Appkr\Api\TransformerAbstract;
use League\Fractal;
use League\Fractal\ParamBag;

class {{ $subject->transformer }} extends TransformerAbstract
{
@if($includes->count() > 0)
    @include('api::partial.property')
@endif

    /**
     * Transform single resource.
     *
     * @param \{{ $subject->model }} ${{ $subject->object }}
     * @return array
     */
    public function transform({{ $subject->basename }} ${{ $subject->object }})
    {
        return [
            'id' => (int) ${{ $subject->object }}->id,
            // ...
            'created' => ${{ $subject->object }}->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('{{ $subject->route }}', ${{ $subject->object }}->id),
            ],
        ];
    }

@forelse($includes as $include)
  @if ($include->type == 'collection')
    @include('api::partial.method-collection')
  @else
    @include('api::partial.method-item')
  @endif
@empty
@endforelse
}
