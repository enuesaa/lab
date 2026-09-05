import { buildProjectMarkdown } from '$lib/prototype/server/markdown'
import { extractCodeFiles, extractInlineFile } from '$lib/prototype/server/files'
import { getProjectV2, listProjectsV2 } from '$lib/prototype/server/project'

export const prerender = true

export async function GET({ params: { name } }) {
	let project = await getProjectV2(name)
	project = await extractCodeFiles(project)
	project = await extractInlineFile(project)
	const body = buildProjectMarkdown(project)

	const res = new Response(body, {
		headers: {
			'Content-Type': 'text/markdown; charset=utf-8',
		},
	})
	return res
}

type Entry = {
	name: string
}
export async function entries(): Promise<Entry[]> {
	const projects = await listProjectsV2()
	return projects.map((p) => ({ name: p.name }))
}
