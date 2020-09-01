<?php namespace App\Libraries;

class JobLib
{
    protected $jobModel;

    private function __construct()
    {
        $this->jobModel = model('App\Models\JobModel', false);
    }

    /**
     * 특정 Entity를 찾아서 수정
     *
     * @param int $id : 직업 일련번호
     * @return void
     */
    public function save($resource = array())
    {
        $job = $this->jobModel->find($resource['id']);

        $job->name = $resource['name'];

        $this->jobModel->save($job);

        // Note: Entity를 많이 사용하는 경우를 위해 CodeIgniter는 Entity 개발을 보다 간단하게 해주는 몇 가지 편리한 기능으 제공하는 내장된 Entity 클래스를 제공한다.
    }
}