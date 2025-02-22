export const realBaseUrl = 'https://lab.enuesaa.dev'
export const localBaseUrl = 'http://localhost:3000'

type Page = {
	name: string
	path: string
}

export const pages: Page[] = [
	{ name: 'CodePipeline AppConfig Deployment', path: '/prototype/aws-codepipeline-appconfig-terraform' },
]
