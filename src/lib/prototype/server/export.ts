import type { Project, UnitFiles } from '../types'
import { readConfig } from './config'
import { extractFiles } from './files'
import { listNames } from './list'

export const listProjects = async (): Promise<Project[]> => {
	let list = []

	for (const name of await listNames()) {
		const project = await getProject(name)
		list.push(project)
	}

	// ignore if published is null
	list = list.filter(a => a.published !== undefined && a.published !== null)

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
		if (unit.open === undefined) {
			continue
		}
		unitfiles[unit.title] = await extractFiles(project.name, unit?.ignore ?? [])
	}

	return unitfiles
}
