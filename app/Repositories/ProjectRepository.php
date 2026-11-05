<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    /**
     * @return list<array{id: string, title: string, category: string, description: string, image: string, image_alt: string, url: string, technologies: list<string>}>
     */
    public function all(): array
    {
        return Project::query()
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->map(static fn (Project $project): array => $project->toArray())
            ->all();
    }

    /**
     * @return array{id: string, title: string, category: string, description: string, image: string, image_alt: string, url: string, technologies: list<string>}|null
     */
    public function find(string $id): ?array
    {
        $project = Project::query()->find($id);

        return $project?->toArray();
    }

    public function exists(string $id): bool
    {
        return Project::query()->whereKey($id)->exists();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): void
    {
        Project::query()->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(string $id, array $data): void
    {
        Project::query()->whereKey($id)->update($data);
    }

    public function delete(string $id): void
    {
        Project::query()->whereKey($id)->delete();
    }
}
