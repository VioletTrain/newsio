<?php

namespace Newsio\UseCase;

use Newsio\Boundary\CategoryBoundary;
use Newsio\Boundary\IdBoundary;
use Newsio\Boundary\LinksBoundary;
use Newsio\Boundary\TagsBoundary;
use Newsio\Boundary\TitleBoundary;
use Newsio\Exception\AlreadyExistsException;
use Newsio\Model\Event;

class CreateEventUseCase
{
    private CreateTagsUseCase $createTagsUseCase;
    private CreateLinksUseCase $createLinksUseCase;

    public function __construct()
    {
        $this->createTagsUseCase = new CreateTagsUseCase();
        $this->createLinksUseCase = new CreateLinksUseCase();
    }

    /**
     * @param TitleBoundary $title
     * @param TagsBoundary $tags
     * @param LinksBoundary $links
     * @param CategoryBoundary $category
     * @return Event
     * @throws \Newsio\Exception\AlreadyExistsException
     * @throws \Newsio\Exception\BoundaryException
     * @throws \Newsio\Exception\InvalidWebsiteException
     */
    public function create(TitleBoundary $title, TagsBoundary $tags, LinksBoundary $links, CategoryBoundary $category): Event
    {
        $this->checkTitle($title);
        $this->createLinksUseCase->checkLinks($links);

        $event = new Event();
        $event->fill([
            'title'       => $title->getValue(),
            'category_id' => $category->getValue(),
        ]);
        $event->save();

        $this->createTagsUseCase->createTags($tags)->createEventTags($event->id, $tags);
        $this->createLinksUseCase->createLinks(new IdBoundary($event->id), $links);

        return $event;
    }

    /**
     * @param TitleBoundary $title
     * @return CreateEventUseCase
     * @throws AlreadyExistsException
     */
    public function checkTitle(TitleBoundary $title): CreateEventUseCase
    {
        if ($event = Event::query()->where('title', 'like', '%' . $title->getValue() . '%')->first()) {
            throw new AlreadyExistsException('Event with title \'' . $title->getValue() . '\' already exists', [
                'event' => $event
            ]);
        }

        return $this;
    }
}
