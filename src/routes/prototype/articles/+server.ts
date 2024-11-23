import { listProjects } from '$lib/prototype/server/project'
import { json } from '@sveltejs/kit'

export const prerender = true

type Item = {
	url: string
	title: string
	published: string
}
export async function GET() {
	const projects = await listProjects()

	const items: Item[] = []
	for (const project of projects) {
		items.push({
			url: `https://lab.enuesaa.dev/prototype/${project.name}`,
			title: project.title,
			published: project.published,
		})
	}

	return json({ items })
}
