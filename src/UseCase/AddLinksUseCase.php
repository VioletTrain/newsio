<?php

namespace Newsio\UseCase;

use Illuminate\Support\Collection;
use Newsio\Boundary\IdBoundary;
use Newsio\Boundary\LinksBoundary;
use Newsio\Exception\ModelNotFoundException;
use Newsio\Model\Event;

class AddLinksUseCase
{
    /**
     * @param IdBoundary $id
     * @param LinksBoundary $links
     * @return Collection
     * @throws ModelNotFoundException
     * @throws \Newsio\Exception\AlreadyExistsException
     * @throws \Newsio\Exception\BoundaryException
     * @throws \Newsio\Exception\InvalidWebsiteException
     */
    public function addLinks(IdBoundary $id, LinksBoundary $links)
    {
        $createLinksUseCase = new CreateLinksUseCase();

        if (!$event = Event::query()->find($id->getValue())) {
            throw new ModelNotFoundException('Event');
        }

        $existingLinks = $event->links->pluck('content');
        $createLinksUseCase->checkLinks($links)->createLinks(new IdBoundary($event->id), $links);

        return $event->refresh()->links->pluck('content')->diff($existingLinks);
    }
}