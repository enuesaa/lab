import type { Project, UnitWithTreeData } from '../types'
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

export const getProjectWithFiles = async (name: string): Promise<Project & {units: UnitWithTreeData[]}> => {
	const project = await getProject(name)
	const data: Project & {units: UnitWithTreeData[]} = {
		...project,
		units: [],
	}
	for (const unit of project.units) {
		data.units.push({
			...unit,
			files: await extractFiles(name, unit?.filetree?.ignore ?? []),
		})
	}
	return data
}
