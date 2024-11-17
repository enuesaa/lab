import type { Project, UnitFiles } from '../types'
import { readConfig } from './config'
import { extractFiles } from './files'
import { listNames } from './list'

export const listProjects = async (): Promise<Project[]> => {
	const list = []

	for (const name of await listNames()) {
		const project = await getProject(name)
		list.push(project)
	}

	// sort by published desc
	list.sort((a, b) => (a.published > b.published ? -1 : 1))

	return list
}

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

export const getUnitFiles = async (project: Project): Promise<UnitFiles> => {
	const unitfiles: UnitFiles = {}

	for (const unit of project.units) {
		if (unit.filetree === undefined) {
			continue
		}
		unitfiles[unit.name] = await extractFiles(project.name, unit?.filetree?.ignore ?? [])
	}

	return unitfiles
}
