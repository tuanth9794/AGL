import React, {useEffect, useState } from 'react';
import { Button, Form, Input, Table, Divider, Tag} from 'antd';

const columns = [
    {
        title: 'name',
        dataIndex: 'name',
        key: 'name',
        render: text => <a href="javascript:;">{text}</a>,
    },
    {
        title: 'Google rank',
        dataIndex: 'googleRank',
        key: 'googleRank',
    },
    {
        title: 'Google search',
        dataIndex: 'googleSearch',
        key: 'googleSearch',
    },
    {
        title: 'Yahoo rank',
        dataIndex: 'yahooRank',
        key: 'yahooRank',
    },
    {
        title: 'Yahoo search',
        dataIndex: 'yahooSearch',
        key: 'yahooSearch',
    },

];


const Index = () => {

    const [data, setData] = useState([])
    const fetchData = () => {
        fetch("http://localhost/AGL/public/api/keyword")
            .then(response => {
                return response.json()
                console.log(response.json())
            })
            .then(data => {
                setData(data)
            })
    }
    useEffect(() => {
        fetchData()
    }, [])

    const onSubmit = (e) => {
        e.preventDefault();
        if (!query) return;

        async function fetchData() {
            const response = await fetch(
                'http://localhost/AGL/public/api/keyword',{method: "POST",}
            );
            const data = await response.json();
            const results = data.Search;
            setData(results);
        }
        fetchData();
    };
    return (
        <>
            <Form
                onSubmit={onSubmit}
                name="wrap"
                labelCol={{ flex: '110px' }}
                labelAlign="left"
                labelWrap
                wrapperCol={{ flex: 1 }}
                colon={false}
                style={{ maxWidth: 600 }}
            >
                <Form.Item label="URL" name="website" rules={[{ required: true }]}>
                    <Input />
                </Form.Item>

                <Form.Item label="Keywords" name="keyword" rules={[{ required: true }]}>
                    <Input.TextArea/>
                </Form.Item>

                <Form.Item label=" ">
                    <Button type="primary" htmlType="submit">
                        Search
                    </Button>
                </Form.Item>
            </Form>
            <Table columns={columns} dataSource={data} scroll={{x: 768}} />
        </>
    )
}

export default Index
