import type { Project } from '../types'
import { readConfig } from './config'
import { listPrototypeNames } from './list'

export const getProject = async (name: string): Promise<Project> => {
	const config = await readConfig(name)
	const project = {
		name,
		title: config.title,
		description: config.description,
		published: config.published,
    units: config.units,
	}

	return project
}

export const listProjects = async (): Promise<Project[]> => {
	const list = []

	for (const name of await listPrototypeNames()) {
		const project = await getProject(name)
		list.push(project)
	}

	// sort by published desc
	list.sort((a, b) => a.published > b.published ? -1 : 1)

	return list
}
