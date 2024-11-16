import type { PageServerLoad } from './$types'
import { listProjects } from '$lib/prototype/server/export'
import type { Project } from '$lib/prototype/types'

type Data = {
	projects: Project[]
}
export const load: PageServerLoad<Data> = async () => {
	const projects = await listProjects()

	return { projects }
}
