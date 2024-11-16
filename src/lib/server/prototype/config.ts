import type { Config, PrototypeProject } from '$lib/server/prototype/types'
import fs from 'node:fs/promises'
import YAML from 'yaml'

export const readConfig = async (name: string): Promise<Config> => {
	const path = `./data/${name}/.prototype.yml`
	const text = await fs.readFile(path, 'utf8')

	return YAML.parse(text) as Config
}

export const getProject = async (name: string): Promise<PrototypeProject> => {
	const config = await readConfig(name)
	const project = {
		name,
		title: config.title,
		description: config.description,
		published: config.published,
	}

	return project
}